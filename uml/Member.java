public class Member extends User {

	private string phone;
	private string address;
	private string[] role = ['ROLE_ADMIN'];

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

	public string getAddress() {
		return this.address;
	}

	/**
	 * 
	 * @param address
	 */
	public void setAddress(string address) {
		this.address = address;
	}

	public string[] getRole() {
		return this.role;
	}

	/**
	 * 
	 * @param role
	 */
	public void setRole(string[] role) {
		this.role = role;
	}

}