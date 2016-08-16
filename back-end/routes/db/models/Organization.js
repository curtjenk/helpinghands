var Organization = function (data) {
	data = data || {};
	if (data.id) {
		this.id = data.id;
	}
    this.name = data.name;
	this.email = data.email;
	this.phone = data.phone;
	this.address1 = data.address1;
	this.address2 = data.address2;
	this.city = data.city;
	this.state = data.state;
	this.zip = data.zip;
};

module.exports = Organization;
