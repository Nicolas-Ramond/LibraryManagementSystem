public class User {

	private string firstName;
	private string lastName;
	private string email;
	private string password;
	private string[] roles = [];
	private Image avatar;

	public string getFirstName() {
		return this.firstName;
	}

	/**
	 * 
	 * @param firstName
	 */
	public void setFirstName(string firstName) {
		this.firstName = firstName;
	}

	public string getLastName() {
		return this.lastName;
	}

	/**
	 * 
	 * @param lastName
	 */
	public void setLastName(string lastName) {
		this.lastName = lastName;
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

	public string getPassword() {
		return this.password;
	}

	/**
	 * 
	 * @param password
	 */
	public void setPassword(string password) {
		this.password = password;
	}

	public string[] getRoles() {
		return this.roles;
	}

	/**
	 * 
	 * @param roles
	 */
	public void setRoles(string[] roles) {
		this.roles = roles;
	}

	public Image getAvatar() {
		return this.avatar;
	}

	/**
	 * 
	 * @param avatar
	 */
	public void setAvatar(Image avatar) {
		this.avatar = avatar;
	}

}