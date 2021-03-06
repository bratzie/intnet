package bean;

public class ClosedOrderBean extends OrderBean {

	private String userIdSeller;

	/**
	 * Class assumes that the price of the buyOrder is greater than the one in
	 * the sellOrder.
	 */
	public ClosedOrderBean(OrderBean buyOrder, OrderBean sellOrder) {
		super();
		setName(buyOrder.getName());
		setPrice(buyOrder.getPrice());
		setAmount(Math.min(buyOrder.getAmount(),sellOrder.getAmount()));
		setUserId(buyOrder.getUserId());
		setUserIdSeller(sellOrder.getUserId());
	}
	
	public ClosedOrderBean(){
		
	}

	public String getUserIdSeller() {
		return userIdSeller;
	}
	
	public void setUserIdSeller(String userIdSeller) {
		this.userIdSeller = userIdSeller;
	}

}