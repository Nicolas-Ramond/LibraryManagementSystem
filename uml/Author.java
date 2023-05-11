public class Author {

	private String firstName;
	private String lastName;
	private text biography;
	private Date birthday;

	public String getFirstName() {
		return this.firstName;
	}

	/**
	 * 
	 * @param firstName
	 */
	public void setFirstName(String firstName) {
		this.firstName = firstName;
	}

	public String getLastName() {
		return this.lastName;
	}

	/**
	 * 
	 * @param lastName
	 */
	public void setLastName(String lastName) {
		this.lastName = lastName;
	}

	public text getBiography() {
		return this.biography;
	}

	/**
	 * 
	 * @param biography
	 */
	public void setBiography(text biography) {
		this.biography = biography;
	}

	public Date getBirthday() {
		return this.birthday;
	}

	/**
	 * 
	 * @param birthday
	 */
	public void setBirthday(Date birthday) {
		this.birthday = birthday;
	}

}