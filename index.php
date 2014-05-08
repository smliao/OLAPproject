

<html>
	<head>
		<title> OLAP </title>
	</head>

	<body>
		<form name="olap" action="index.php" method="GET">
			<table border = 1>
				<tr>
					<th> Time </th>
					<th> Product </th>
					<th> Promotion </th>
					<th> Store </th>
					<th> SalesUnit </th>

				</tr>

				<tr>
				<td>
					<select name="time_menu">
						<option value="date"> date </option>
						<option value="day_of_week"> day_of_week </option>
						<option value="day_number_in_month"> day_number_in_month </option>
					</select>
				</td>

				<td>
					<select name="product_menu">
						<option value="description"> description </option>
						<option value="full_description"> full_description </option>
						<option value="SKU_number"> SKU_number </option>
					</select>
				</td>

				<td>
					<select name="promotion_menu">
						<option value="promotion_name"> promotion_name </option>
						<option value="price_reduction_type"> price_reduction_type </option>
						<option value="ad_type"> ad_type </option>
					</select>
				</td>

				<td>
					<select name="store_menu">
						<option value="store_number"> store_number </option>
						<option value="store_street_address"> store_street_address </option>
						<option value="city"> city </option>
					</select>
				</td>

				<td>
					<select name="salesfact_menu">
						<option value="dollar_sales"> dollar_sales </option>
						<option value="unit_sales"> unit_sales </option>
						<option value="dollar_cost"> dollar_cost </option>
						<option value="customer_count"> customer_count </option>
					</select>
				</td>
				</tr>
			</table>
			<input type="submit" value="Submit OLAP query!"><br />

			<?php
				$con = mysqli_connect("localhost", "root", "", "cs157b");	
				if(mysqli_connect_errno()){
				echo "failed to connect to MySQL: " . mysqli_connect_errno();
				}

				$time = "date";
				$promotion = "promotion_name";
				$product = "SKU_number";
				$store = "store_number";
				$sales = "dollar_sales";

				$query = "SELECT $time , $promotion , $product , $store , sum(salesfact.$sales) as $sales 
						  FROM time, promotion, product, store, salesFact
						  WHERE time.time_key = salesfact.time_key AND promotion.promotion_key = salesfact.promotion_key AND
						  	product.product_key = salesfact.product_key AND store.store_key = salesfact.store_key 
						  GROUP BY time , promotion, product, store LIMIT 20";

				$query2 = "SELECT $time , $promotion, $product, $store,  sum(salesfact.$sales) as dollar_sales
						   From time , promotion, product, store , salesfact
						   WHERE time.time_key = salesfact.time_key AND promotion.promotion_key = salesfact.promotion_key 
						   		 AND product.product_key = salesfact.product_key AND store.store_key = salesfact.store_key
						   GROUP BY time.$time LIMIT 15";

				echo $query2;
				$data = mysqli_query($con, $query2 );

				echo "<table border = 1> 
						<tr>
						<th> time </th>
						<th> promotion </th>
						<th> product </th>
						<th> store </th>
						<th> sales </th>
						</tr>";
				while($row = mysqli_fetch_array($data)){
					echo "<tr>";
					echo "<td>" . $row[$time] . "</td>";
					echo "<td>" . $row[$promotion] . "</td>";
					echo "<td>" . $row[$product] . "</td>";
					echo "<td>" . $row[$store] . "</td>";
					echo "<td>" . $row[$sales] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			?>
		</form>
	</body>
</html>