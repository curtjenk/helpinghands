var Ticket = function (data) {
	data = data || {};
	//console.log(data);
	if (data.idTicket) {
		this.idTicket = data.idTicket;
	}
	if (data.date_create) {
		this.date_create = data.date_create;
	}
	this.client_datetime_string = data.client_datetime_string;
	this.idUser = data.idUser;

	this.contact_first_name = data.contact_first_name;
	this.contact_last_name = data.contact_last_name;
	this.contact_email = data.contact_email;
	this.contact_phone = data.contact_phone;
	this.contact_mobile = data.contact_mobile;
	this.pet = data.pet;
	this.entry_point = data.entry_point;

	this.issue_description = data.issue_description;
	this.details_json = data.details_json;
	this.markers_json = data.markers_json;
	this.notify_preference = data.notify_preference;
	
	this.agree = data.agree;
	if (data.date_resolved) {
		this.date_resolved = data.date_resolved;
	}
	if (data.status_id) {
		this.status_id = data.status_id;
	}
};
module.exports = Ticket;
