<!DOCTYPE html>
<html>
<head>
	<title>Inventory Management System</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style>
		
		body {
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
}
		.sidebar {
    
    height: 100%;
   width: 250px;
   position: fixed;
   z-index: 1;
   top: 0;
   left: 0;
   background-color: #111;
   overflow-x: hidden;
   padding-top: 20px;
 
 
       }
 
       .sidebar ul {
         list-style-type: none;
         margin: 10px;
         padding: 10px;
       }
       .sidebar ul li {
         border-bottom: 2px solid #444;
         padding: 15px;
         text-align: center;
       }
 
       .sidebar ul li a {
         color: #fff;
         display: block;
         font-size: 20px;
         text-decoration: none;
       }
 
       .sidebar ul li a:hover {
         background-color: #444;
       }
 
     
       .dropdown-menu
         {
             display: none;
            
               
       
         }
		
		
		
		
		
	/* Style for sales page */

		
		.container{
			
			background-color:white;
			margin-left:290px;
			margin-right:30px;
			margin-top:2px;
		}
		
	body {
	font-family: Arial, sans-serif;
	background-color:#e7e7e7;
}

h1 {
	text-align: center;
}

table {
	margin: auto;
	border-collapse: collapse;
	width: 100%;
}

th, td {
	padding: 8px;
	text-align: left;
	border-bottom: 1px solid #ddd;
}

th {
	background-color: #f2f2f2;
	color: #333;
}

button {
	background-color: #39A4E0;
	color: white;
	border: none;
	padding: 8px 16px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: 14px;
	margin: 4px 2px;
	cursor: pointer;
	border-radius: 4px;
}

button:hover {
	background-color: #49A4E0;
}
	</style>
</head>
<body>
	
  
	<!-- Menu Side-->
	
	

	<div class="sidebar">
		<ul>
			<li><a href="dash.html">Dashboard</a></li>
	
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
				Roles <i class="fa fa-caret-down"></i>
			  </a>
			  <ul class="dropdown-menu">
				<li><a href="addrole.html">Add Role</a></li>
				<li><a href="manageroles.html">Manage Roles</a></li>
			  </ul>
			</li>
  
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				  Users <i class="fa fa-caret-down"></i>
				</a>
				<ul class="dropdown-menu">
				  <li><a href="adduser.html">Add User</a></li>
				  <li><a href="manageuser.html">Manage Users</a></li>
				</ul>
			  </li>
  
  
	
			<li><a href="categories.html">Categories</a></li>
			
		
	
	
			<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			  Products <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="addproduct.html">Add Product</a></li>
			  <li><a href="manageproduct.html">Manage Products</a></li>
			</ul>
		  </li>
	
	
		  <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			  Sales <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="addsales.html">Add Sales</a></li>
			  <li><a href="managesales.html">Manage Sales</a></li>
			</ul>
		  </li>
	
	  <li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		  Purchases <i class="fa fa-caret-down"></i>
		</a>
		<ul class="dropdown-menu">
		  <li><a href="addpurchases.html">Add Purchase</a></li>
		  <li><a href="managepurchases.html">Manage Purchases</a></li>
		</ul>
		</li>
		  
  
		  <li><a href="report.html">Report</a></li>
		  <li><a href="profile.html">Profile</a></li>
		  <li class="signout"><a href="login.html"><i class="fa fa-sign-out"></i>Sign Out</a></li>
	
		</ul>
	  </div>
  
    
    
	
	<div class="headerl">
    <h1 style="text-align: center; font-weight: bold; font-size:35px;">Sales Report Data</h1>


    <div style="clear: both;"></div>
    <hr style="margin-top:-15px; margin-bottom: 5px;">
  </div>
  <div class="container">
	
	
    <div id="add-category-popup" style="display: none;">
      <form>
        <label for="category-name">Category Name:</label>
        <input type="text" id="category-name" name="category-name"><br><br>
        <button type="submit" id="submit-category" style="background-color: blue; color: white; border: none; padding: 10px 20px; border-radius: 5px;">Submit</button>
      </form>
    </div>

  
	
	<!--Purchases PAGE-->
	
	<table>
		<thead>
			<tr>
        
				<th>Date.</th>
        <th>Product.</th>
				<th>Quantity Sold</th>
				<th>Revenue</th>
				
				
				
				
			</tr>
		</thead>
		<tbody>
			
				
      
		
				
			
				
				
			</tr>
			<tr>
				
                <table>
                    <thead>
                        <tr>
                    
                            <td>01/01/2022</td>
                            <td>Stainless Watch</td>
                            <td>10</td>
                            <td>2100$</td>
                            
                            
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            
                            <td>01/01/2022</td>
                            <td>Stainless Watch</td>
                            <td>10</td>
                            <td>2100$</td>
                    
                            
                        
                            
                            
                        </tr>
                        <tr>
                            <table>
                                <thead>
                                    <tr>
                                
                                        <td>01/01/2022</td>
                                        <td>Stainless Watch</td>
                                        <td>10</td>
                                        <td>2100$</td>
                                        
                                        
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        
                                <td>01/01/2022</td>
                                <td>Stainless Watch</td>
                                <td>10</td>
                                <td>2100$</td>
                                
                                        
                                    
                                        
                                        
                                    </tr>
                                    <tr>
    
			<!-- Diğer satırlar buraya eklenebilir -->
		</tbody>
	</table>
	</div>






	<script 
  


  type="text/javascript">

  var dropdown = document.getElementsByClassName("dropdown-toggle");
    var i;
    
    for (i = 0; i < dropdown.length; i++) {
      dropdown[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
          dropdownContent.style.display = "none";
        } else {
          dropdownContent.style.display = "block";
        }
      });
    }
     
    const addCategoryBtn = document.getElementById("add-category-btn");
  const addCategoryPopup = document.getElementById("add-category-popup");

  // show the popup when the "Add Categories" button is clicked
  addCategoryBtn.addEventListener("click", () => {
    addCategoryPopup.style.display = "block";
  });

  // hide the popup when the "Submit" button is clicked
  const submitCategoryBtn = document.getElementById("submit-category");
  submitCategoryBtn.addEventListener("click", () => {
    addCategoryPopup.style.display = "none";
  });

    </script>

</body>
</html>