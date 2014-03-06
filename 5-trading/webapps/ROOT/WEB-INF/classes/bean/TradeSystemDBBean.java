package bean;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;

import javax.naming.Context;
import javax.naming.InitialContext;
import javax.naming.NamingException;
import javax.sql.DataSource;

import bean.TradeSystemBean.OrderStatus;

public class TradeSystemDBBean {

	private Connection conn;

	public TradeSystemDBBean() {
		try {
			Context initCtx = new InitialContext();
			Context envCtx = (Context) initCtx.lookup("java:comp/env");
			DataSource ds = (DataSource) envCtx.lookup("jdbc/db");
			conn = ds.getConnection();
		} catch (SQLException e) {
		} catch (NamingException e) {
		}
	}

	public void close() {
		try {
			conn.close();
		} catch (SQLException e) {
		}
	}

	public void addSecurity(String security) {
		Statement stmt = null;
		try {
			stmt = conn.createStatement();
			PreparedStatement statement = conn
					.prepareStatement("INSERT INTO securities (NAME) VALUES (?)");
			statement.setString(1, security);
			statement.execute();
		} catch (SQLException e) {
			System.err.println("Failed to execute query");
		}
	}

	public ArrayList<String> getSecurities() {
		ArrayList<String> securities = new ArrayList<String>();
		try {
			Statement stmt = conn.createStatement();
			ResultSet rs = null;
			String query = "select * from securities";
			rs = stmt.executeQuery(query);
			while (rs.next()) {
				String secutity = rs.getString("NAME");
				securities.add(secutity);
			}
		} catch (SQLException e) {
		}
		return securities;
	}

	public void addOrder(OrderBean order, TradeSystemBean.OrderStatus status) {
		Statement stmt = null;
		try {
			stmt = conn.createStatement();
			PreparedStatement statement = conn
					.prepareStatement("INSERT INTO orders (NAME, TYPE, PRICE, AMOUNT, UID) VALUES (?,?,?,?,?)");
			statement.setString(1, order.getName());
			if (status == OrderStatus.buy) {
				statement.setString(2, "B");
			} else {
				statement.setString(2, "S");
			}
			statement.setFloat(3, order.getPrice());
			statement.setInt(4, order.getAmount());
			statement.setString(5, order.getUserId());
			statement.execute();
		} catch (SQLException e) {
			System.err.println("Failed to execute query");
		}
	}
	
	public ArrayList<OrderBean> getOrders(TradeSystemBean.OrderStatus status) {
		ArrayList<OrderBean> orders = new ArrayList<OrderBean>();
		try {
			Statement stmt = conn.createStatement();
			ResultSet rs = null;
			PreparedStatement statement = conn.prepareStatement("SELECT * FROM orders WHERE TYPE=(?)");
			if (status == OrderStatus.buy) {
				statement.setString(1, "B");
			} else {
				statement.setString(1, "S");
			}
			rs = statement.executeQuery();
			while (rs.next()) {
				OrderBean order = new OrderBean();
				
				order.setName(rs.getString("NAME"));
				order.setPrice(rs.getFloat("PRICE"));
				order.setAmount(rs.getInt("AMOUNT"));
				order.setUserId(rs.getString("UID"));
				orders.add(order);
			}
		} catch (SQLException e) {
		}
		return orders;
	}
	
	public void removeOrder(OrderBean order, TradeSystemBean.OrderStatus status) {
		Statement stmt = null;
		try {
			stmt = conn.createStatement();			
			PreparedStatement statement = conn
					.prepareStatement("DELETE FROM orders (NAME, TYPE, PRICE, AMOUNT, UID) VALUES (?,?,?,?,?)");
			statement.setString(1, order.getName());
			if (status == OrderStatus.buy) {
				statement.setString(2, "B");
			} else {
				statement.setString(2, "S");
			}
			statement.setFloat(3, order.getPrice());
			statement.setInt(4, order.getAmount());
			statement.setString(5, order.getUserId());
			statement.execute();
		} catch (SQLException e) {
			System.err.println("Failed to execute query");
		}
	}
	
	public void addClosedOrder(ClosedOrderBean order) {
		Statement stmt = null;
		try {
			stmt = conn.createStatement();
			PreparedStatement statement = conn
					.prepareStatement("INSERT INTO trades (NAME, PRICE, AMOUNT, BUYER, SELLER) VALUES (?,?,?,?,?)");
			statement.setString(1, order.getName());			
			statement.setFloat(2, order.getPrice());
			statement.setInt(3, order.getAmount());
			statement.setString(4, order.getUserId());
			statement.setString(5, order.getUserIdSeller());
			statement.execute();
		} catch (SQLException e) {
			System.err.println("Failed to execute query");
		}
	}
	
	public ArrayList<ClosedOrderBean> getClosedOrders() {
		ArrayList<ClosedOrderBean> trades = new ArrayList<ClosedOrderBean>();
		try {
			Statement stmt = conn.createStatement();
			ResultSet rs = null;
			ClosedOrderBean order;
			String query = "select * from trades";
			rs = stmt.executeQuery(query);
			while (rs.next()) {
				order = new ClosedOrderBean();
				order.setName(rs.getString("NAME"));
				order.setPrice(rs.getFloat("PRICE"));
				order.setAmount(rs.getInt("AMOUNT"));
				order.setUserId(rs.getString("BUYER"));
				order.setUserId(rs.getString("SELLER"));
				trades.add(order);
			}
		} catch (SQLException e) {
		}
		return trades;
	}

}
