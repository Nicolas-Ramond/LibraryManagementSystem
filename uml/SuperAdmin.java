public class SuperAdmin extends User {

	private string[] roles = ['ROLE_Super_Admin'];

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