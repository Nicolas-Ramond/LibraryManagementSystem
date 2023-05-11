public class Library {

	private string name;
	private string address;
	private string phone;
	private string email;
	private DateTime openingDate;
	private DateTime closingDate;
	private Language language;
	private Service[] services;
	private int attribute;

	public void getName() {
		// TODO - implement Library.getName
		throw new UnsupportedOperationException();
	}

	/**
	 * 
	 * @param name
	 */
	public void setName(int name) {
		// TODO - implement Library.setName
		throw new UnsupportedOperationException();
	}

	public void getAddress() {
		// TODO - implement Library.getAddress
		throw new UnsupportedOperationException();
	}

	/**
	 * 
	 * @param address
	 */
	public void setAddress(int address) {
		// TODO - implement Library.setAddress
		throw new UnsupportedOperationException();
	}

	public string getPhone() {
		return this.phone;
	}

	/**
	 * 
	 * @param phone
	 */
	public void setPhone(string phone) {
		this.phone = phone;
	}

	public string getEmail() {
		return this.email;
	}

	/**
	 * 
	 * @param email
	 */
	public void setEmail(string email) {
		this.email = email;
	}

	public DateTime getOpeningDate() {
		return this.openingDate;
	}

	/**
	 * 
	 * @param openingDate
	 */
	public void setOpeningDate(DateTime openingDate) {
		this.openingDate = openingDate;
	}

	public DateTime getClosingDate() {
		return this.closingDate;
	}

	/**
	 * 
	 * @param closingDate
	 */
	public void setClosingDate(DateTime closingDate) {
		this.closingDate = closingDate;
	}

	public Language getLanguage() {
		return this.language;
	}

	/**
	 * 
	 * @param language
	 */
	public void setLanguage(Language language) {
		this.language = language;
	}

	public Service[] getServices() {
		return this.services;
	}

	/**
	 * 
	 * @param services
	 */
	public void setServices(Service[] services) {
		this.services = services;
	}

	public void getAttribute() {
		// TODO - implement Library.getAttribute
		throw new UnsupportedOperationException();
	}

	/**
	 * 
	 * @param attribute
	 */
	public void setAttribute(int attribute) {
		this.attribute = attribute;
	}

}