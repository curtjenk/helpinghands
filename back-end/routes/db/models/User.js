var Q = require('q');
var bcrypt = require('bcrypt-nodejs');
var bcryptSaltRounds = 8;

var User = function (data) {
	data = data || {};
	if (data.idUser) {
		this.idUser = data.idUser;
	}
	this.idChurch = data.idChurch;
	this.user_type = data.user_type;
    this.name = data.name;
	this.email = data.email;
	this.password = data.password;
	this.mobile_phone = data.mobile_phone;
	this.address = data.address;
	this.city = data.city;
	this.state = data.state;
	this.zip = data.zip;
};
User.prototype.hashPassword = function () {
	// console.log('hashpassword');
	var deferred = Q.defer();
	this.password = bcrypt.hashSync(this.password);
	deferred.resolve({p:this.password});
	return deferred.promise;
};
User.prototype.passwordMatch = function (password) {
    var match = bcrypt.compareSync(password1, this.password1); //returns boolean
    if (match) {
        return true;
    } else {
        throw new Error("Password does not match");
    }
};

module.exports = User;
