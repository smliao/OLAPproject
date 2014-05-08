

<html>
	<head>
		<title> OLAP </title>
	</head>

	<body>
		<form name="olap" action="index.php" method="GET">
			<table border = 1>
				<tr>
					<th> Time </th>
					<th> Promotion </th>
					<th> Product </th>
					<th> Store </th>
					<th> SalesUnit </th>

				</tr>

				<tr>
				<td>
					<select name="time_menu">
						<option value="date"> date </option>
						<option value="day_of_week"> day_of_week </option>
						<option value="day_number_in_month"> day_number_in_month </option>
						<option value="week_number_in_year"> week_number_in_year </option>
						<option value="week_number_overall"> week_number_overall </option>
						<option value="month"> month </option>
						<option value="quarter"> quarter </option>
						<option value="fiscal_period"> fiscal_period </option>
						<option value="year"> year </option>
						<option value="holiday_flag"> holiday </option>
					</select>
				</td>

				<td>
					<select name="promotion_menu">
						<option value="promotion_name"> promotion_name </option>
						<option value="price_reduction_type"> price_reduction_type </option>
						<option value="ad_type"> ad_type </option>
						<option value="display_type"> display_type </option>
						<option value="coupon_type"> coupon_type </option>
						<option value="ad_media_type"> ad_media_type </option>
						<option value="display_provider"> display_provider </option>
						<option value="promo_cost"> promo_cost </option>
						<option value="promo_begin_date"> promo_begin_date </option>
						<option value="promo_end_date"> promo_end_date </option>
					</select>
				</td>

				<td>
					<select name="product_menu">
						<option value="description"> description </option>
						<option value="full_description"> full_description </option>
						<option value="SKU_number"> SKU_number </option>
						<option value="package_size"> package_size </option>
						<option value="brand"> brand </option>
						<option value="subcategory"> subcategory </option>
						<option value="category"> category </option>
						<option value="department"> department </option>
						<option value="package_type"> package_type </option>
						<option value="diet_type"> diet_type </option>
						<option value="weight"> weight </option>
						<option value="weight_unit_of_measure"> weight_unit_of_measure </option>
						<option value="units_per_retail_case"> units_per_retail_case </option>
						<option value="units_per_shipping_case"> units_per_shipping_case </option>
						<option value="cases_per_pallet"> cases_per_pallet </option>
						<option value="shelf_width_cm"> shelf_width_cm </option>
						<option value="shelf_height_cm"> shelf_height_cm </option>
						<option value="shelf_depth_cm"> shelf_width_cm </option>
					</select>
				</td>

				<td>
					<select name="store_menu">
						<option value="store_number"> store_number </option>
						<option value="store_street_address"> store_street_address </option>
						<option value="city"> city </option>
						<option value="store_county"> store_county </option>
						<option value="store_state"> store_state </option>
						<option value="store_zip"> store_zip </option>
						<option value="sales_district"> sale_district </option>
						<option value="sales_region"> sales_region </option>
						<option value="store_manager"> store_manager </option>
						<option value="store_phone"> store_phone </option>
						<option value="store_FAX"> store_FAX </option>
						<option value="floor_plan_type"> floor_plan_type </option>
						<option value="photo_processing_type"> photo_processing_type </option>
						<option value="finance_services_type"> finance_services_type </option>
						<option value="first_opened_date"> first_opened_date </option>
						<option value="last_remodel_date"> last_remodel_date </option>
						<option value="store_sqft"> store_sqft </option>
						<option value="grocery_sqft"> grocery_sqft </option>
						<option value="frozen_sqft"> frozen_sqft </option>
						<option value="meat_sqft"> meat_sqft </option>
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


				$time = $_GET['time_menu'];
				$promotion = $_GET['promotion_menu'];
				$product = $_GET['product_menu'];
				$store = $_GET['store_menu'];
				$sales = $_GET['salesfact_menu'];

				$query = "SELECT $time , $promotion, $product, $store,  sum(salesfact.$sales) as $sales
						   From time , promotion, product, store , salesfact
						   WHERE time.time_key = salesfact.time_key AND promotion.promotion_key = salesfact.promotion_key 
						   		 AND product.product_key = salesfact.product_key AND store.store_key = salesfact.store_key
						   GROUP BY time.$time , promotion.$promotion , product.$product , store.$store limit 100";

			//	echo $query;
				$data = mysqli_query($con, $query );

				echo "<table border = 1> 
						<tr>
						<th> time </th>
						<th> promotion </th>
						<th> product </th>
						<th> store </th>
						<th> sales </th>
						</tr>

						
						<tr style=\"color:#FF0000\">
						<td> $time </td>
						<td> $promotion </td>
						<td> $product </td>
						<td> $store </td>
						<td> $sales </td>
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