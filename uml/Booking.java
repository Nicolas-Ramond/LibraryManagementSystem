public class Booking {

	private datetime startDate;
	private datetime endDate;
	private datetime returnDate;

	public datetime getStartDate() {
		return this.startDate;
	}

	/**
	 * 
	 * @param startDate
	 */
	public void setStartDate(datetime startDate) {
		this.startDate = startDate;
	}

	public datetime getEndDate() {
		return this.endDate;
	}

	/**
	 * 
	 * @param endDate
	 */
	public void setEndDate(datetime endDate) {
		this.endDate = endDate;
	}

	public datetime getReturnDate() {
		return this.returnDate;
	}

	/**
	 * 
	 * @param returnDate
	 */
	public void setReturnDate(datetime returnDate) {
		this.returnDate = returnDate;
	}

}