package bean;

public class OrderBean {

	private String name;
	private float price;
	private int amount;
	private String userId;

	public OrderBean(){
	}
	
	public String getName(){
		return name;
	}

	public float getPrice(){
		return price;
	}
	
	public int getAmount(){
		return amount;
	}
	
	public String getUserId(){
		return userId;
	}
	
	
	public void setName(String name){
		this.name = name;
	}

	public void setPrice(float price){
		this.price = price;
	}
	
	public void setAmount(int amount){
		this.amount = amount;
	}
	
	public void setUserId(String userId){
		this.userId = userId;
	}
	
	


}