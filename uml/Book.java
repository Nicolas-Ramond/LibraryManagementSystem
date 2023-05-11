public class Book {

	private string ISBN;
	private string title;
	private text description;
	private int pageCount;
	private int cover;
	private Author mainAuthor;
	private Author[] authors;
	private int format;

	public string getTitle() {
		return this.title;
	}

	/**
	 * 
	 * @param title
	 */
	public void setTitle(string title) {
		this.title = title;
	}

	public text getDescription() {
		return this.description;
	}

	/**
	 * 
	 * @param description
	 */
	public void setDescription(text description) {
		this.description = description;
	}

	public string getISBN() {
		// TODO - implement Book.getISBN
		throw new UnsupportedOperationException();
	}

	/**
	 * 
	 * @param ISBN
	 */
	public void setISBN(string ISBN) {
		// TODO - implement Book.setISBN
		throw new UnsupportedOperationException();
	}

	public int getPageCount() {
		return this.pageCount;
	}

	/**
	 * 
	 * @param pageCount
	 */
	public void setPageCount(int pageCount) {
		this.pageCount = pageCount;
	}

	public void getAttribute() {
		// TODO - implement Book.getAttribute
		throw new UnsupportedOperationException();
	}

	/**
	 * 
	 * @param attribute
	 */
	public void setAttribute(int attribute) {
		// TODO - implement Book.setAttribute
		throw new UnsupportedOperationException();
	}

	public Image getCover() {
		// TODO - implement Book.getCover
		throw new UnsupportedOperationException();
	}

	/**
	 * 
	 * @param cover
	 */
	public void setCover(Image cover) {
		// TODO - implement Book.setCover
		throw new UnsupportedOperationException();
	}

	public Author getMainAuthor() {
		return this.mainAuthor;
	}

	/**
	 * 
	 * @param mainAuthor
	 */
	public void setMainAuthor(Author mainAuthor) {
		this.mainAuthor = mainAuthor;
	}

}