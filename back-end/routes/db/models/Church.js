var Church = function (data) {
	data = data || {};
	if (data.idChurch) {
		this.idChurch = data.idChurch;
	}
    this.church_name = data.church_name;
	this.pastor_name = data.pastor_name;
	this.email = data.email;
	this.office_phone = data.office_phone;
	this.address = data.address;
	this.city = data.city;
	this.state = data.state;
	this.zip = data.zip;
};

module.exports = Church;
