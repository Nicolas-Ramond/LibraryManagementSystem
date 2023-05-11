public class Admin extends User {

	private string[] roles = ['ROLE_ADMIN'];

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

}