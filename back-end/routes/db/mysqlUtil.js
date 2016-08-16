"use strict";

var Q = require('q');
var mysql = require('promise-mysql');
var config = require('./config');
var User = require('./models/User');

// console.log(config.mysql.username);
//console.log(config.mysql.database);
var pool = mysql.createPool({
	connectionLimit: config.mysql.pool.connectionLimit, //important
	host: config.mysql.host,
	user: config.mysql.username,
	password: config.mysql.password,
	database: config.mysql.database,
	debug: config.mysql.debug
});

var connect = function () {
	"use strict";
	return pool.getConnection().then(function (connection) {
		return connection;
	}).catch(function (error) {
		console.log("Connect failed");
		throw new Error("Connect Failed: 500");
	});
};

var authenticate = function (username, password) {
	"use strict";
	var con = null;
	return pool.getConnection().then(function (connection) {
		con = connection;
		return con.query("SELECT * FROM user WHERE username = ?", username);
	}).then(function (rows) {
		if (rows.length === 0) {
			throw new Error("No user");
		}
		var dbUser = new User(rows[0]);
		return dbUser.passwordMatch(password);
	}).catch(function (excp) {
		console.log(excp);
		throw excp;
	}).finally(function () {
		console.log("releasing connection");
		pool.releaseConnection(con);
	});
};
/*
 user_type 0 = Super User
 user_type 1 = Organization Admin
 user_type 2 = Client
 user_type 3 = Helper

*/
var getAllClients = function () {
	"use strict";
	var con = null;
	return pool.getConnection().then(function (connection) {
		con = connection;
		return con.query("SELECT * FROM user WHERE user_type = 2");
	}).catch(function (excp) {
		console.log(excp);
		throw excp;
	}).finally(function () {
		console.log("releasing connection");
		pool.releaseConnection(con);
	});
};
var getAllClients = function () {
	"use strict";
	var con = null;
	return pool.getConnection().then(function (connection) {
		con = connection;
		return con.query("SELECT * FROM user WHERE user_type = 3");
	}).catch(function (excp) {
		console.log(excp);
		throw excp;
	}).finally(function () {
		console.log("releasing connection");
		pool.releaseConnection(con);
	});
};

module.exports = {
	authenticate: authenticate,
	getAllClients: getAllClients,
	getAllHelpers: getAllHelpers
};
