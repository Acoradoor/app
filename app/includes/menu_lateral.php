<section class="sidebar position-relative">	
  <div class="user-profile px-20 py-15">
    <div class="d-flex align-items-center">			
      <div class="image">
        <img src="../images/avatar/avatar-13.png" class="avatar avatar-lg bg-primary-light" alt="User Image">
       </div>
       <div class="info">
         <a class="dropdown-toggle px-20" data-bs-toggle="dropdown" href="#"><?php echo $nombre_usuario; ?></a>
	 <div class="dropdown-menu">
	   <a class="dropdown-item" href="#" id="addRandomTab10"><i class="ti-user ion-person"></i> Perfil Usuario</a>
	   <a class="dropdown-item" href="#" id="addRandomTab11"><i class="ti-email ion-person-add"></i> Crear Usuario</a>
	   <div class="dropdown-divider"></div>
	     <a class="dropdown-item" href="#" id="addRandomTab9"><i class="ti-settings ion-person-stalker"></i> Perfil Empresa</a>
	   </div>
	 </div>
       </div>
       <ul class="list-inline profile-setting mt-30 mb-20 d-flex justify-content-between">
         <li><a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Search"><i data-feather="search"></i></a></li>
	 <li><a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Notification"><i data-feather="bell"></i></a></li>
	 <li><a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Chat"><i data-feather="message-square"></i></a></li>
	 <li><a href="../includes/auth.php?action=logout" data-bs-toggle="tooltip" data-bs-placement="top" title="Logout"><i data-feather="log-out"></i></a></li>
       </ul>
     </div>
     <div class="multinav">
       <div class="multinav-scroll" style="height: 100%;">	
       <!-- sidebar menu-->
         <ul class="sidebar-menu" data-widget="tree">
	   <li class="header">Gestion </li>
	     <!-- Facturas Ventas -->
	   <li class="treeview"><a href="#"><i class="ion-briefcase"><span class="path1"></span><span class="path2"></span></i><span>Ventas</span><span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a>
	     <ul class="treeview-menu">
	       <li><a id="addRandomTab8" href="#"><i class="ion-clipboard"><span class="path1"></span><span class="path2"></span></i>Presupuestos</a></li>
	       <li><a id="addRandomTab3" href="#"><i class="ion-ios-list-outline"><span class="path1"></span><span class="path2"></span></i>Pedidos</a></li>
	       <li><a id="addRandomTab4" href="#"><i class="glyphicon-list-alt"><span class="path1"></span><span class="path2"></span></i>Albaranes</a></li>
	       <li><a id="addRandomTab5" href="#"><i class="ion-android-clipboard"><span class="path1"></span><span class="path2"></span></i>Albaranes de Depósito</a></li>
	       <li><a id="addRandomTab1" href="#"><i class="ion-ios-paper-outline"><span class="path1"></span><span class="path2"></span></i>Facturas</a></li>
	        <li><a href="#" id="addRandomTab12"><i class="ion-ios-contact"><span class="path1"></span><span class="path2"></span></i>Clientes</a></li>
	        <li><a id="" href="#"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Atributos</a></li>
	        <li><a id="" href="#"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Tarifas</a></li>
	        <li><a id="" href="#"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Agentes Comerciales</a></li>
	        <li><a id="" href="#"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Condiciones Especiales</a></li>
	     </ul>
	   </li>
	   <!-- Facturas Compras -->
	   <li class="treeview">
	     <a href="#"><i span class="ion-android-cart"><span class="path1"></span><span class="path2"></span></i><span>Compras</span><span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a>
	       <ul class="treeview-menu">
	         <li class="treeview">
		   <a href="#" id="addRandomTab13"><i class="ion-ios-contact-outline"><span class="path1"></span><span class="path2"></span></i>Proveedores<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a>
		     <ul class="treeview-menu">
		       <li><a href="extra_calendar.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Calendar</a></li>
		       <li><a href="contact_app.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Contact List</a></li>
		       <li><a href="contact_app_chat.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Chat</a></li>
		       <li><a href="extra_taskboard.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Todo</a></li>
		     </ul>
		   </li>					
		   <li><a href="#" id="addRandomTab15"><i class="icon-Incoming-mail"><span class="path1"></span><span class="path2"></span></i><span>Facturas</span></a></li>					
		   <li><a href="email_index.html"><i class="icon-Mail-notification"><span class="path1"></span><span class="path2"></span></i><span>Emails</span></a></li>
		   <li class="treeview"><a href="#"><i class="icon-User"><span class="path1"></span><span class="path2"></span></i><span>Usefull Page</span><span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a>
		     <ul class="treeview-menu">
		       <li><a href="invoice.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Invoice</a></li>
		       <li><a href="invoicelist.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Invoice List</a></li>	
		       <li><a href="extra_app_ticket.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Support Ticket</a></li>
		       <li><a href="extra_profile.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>User Profile</a></li>
		       <li><a href="contact_userlist_grid.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Userlist Grid</a></li>
		       <li><a href="contact_userlist.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Userlist</a></li>	
		       <li><a href="sample_faq.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>FAQs</a></li>
		     </ul>
		   </li>		  
		   <li class="treeview"><a href="#"><i class="icon-Clipboard"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i><span>Extra Pages</span><span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a>
		     <ul class="treeview-menu">
		       <li><a href="sample_blank.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Blank</a></li>
		       <li><a href="sample_coming_soon.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Coming Soon</a></li>
		       <li><a href="sample_custom_scroll.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Custom Scrolls</a></li>
		       <li><a href="sample_gallery.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Gallery</a></li>
		       <li><a href="sample_lightbox.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Lightbox Popup</a></li>
		       <li><a href="sample_pricing.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Pricing</a></li>
		     </ul>
		   </li> 
		   <li class="treeview"><a href="#"><i class="icon-Marker"></i><span>Maps</span><span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a>
		     <ul class="treeview-menu">
		       <li><a href="map_google.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Google Map</a></li>
		       <li><a href="map_vector.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Vector Map</a></li>
		     </ul>
		   </li>
		 </ul>
	   <!-- Almacén -->
	   <li class="treeview"><a href="#"><i class="ion-ios-box"><span class="path1"></span><span class="path2"></span></i><span>Almacén</span><span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a>
	     <ul class="treeview-menu">
	       <li><a id="addRandomTab14" href="#"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Productos</a></li>
	       <li><a id="addRandomTab6" href="#"><i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>Stock</a></li>
	     </ul>
	   </li>
	    <!-- Contabilidad -->
	      <li class="header">CONTABILIDAD </li><li class="treeview"><a href="#"><i class="ion-calculator"><span class="path1"></span><span class="path2"></span></i><span>contabilidad</span><span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a>
	        <ul class="treeview-menu">			
		  <li><a id="addRandomTab7" href="#"><i class="ion-ios-calculator-outline"><span class="path1"></span><span class="path2"></span></i>Libro Diario</a></li>
		  <li><a id="addRandomTab71" href="#"><i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>Libro Mayor</a></li>
            <li><a id="addRandomTab72" href="#"><i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>Plan de Cuentas</a></li>
            <li><a id="addRandomTab73" href="#"><i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>Catálogo de Cuentas</a></li>
		  </ul>
		</li>
				
										
				<!-- Tesorería -->
				<li class="header">Tesorería</li>
				<li class="treeview">
				  <a href="#">
					<i class="ion-social-euro"><span class="path1"></span><span class="path2"></span></i>
					<span>Tesorería</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href="widgets_blog.html"><i class="ion-cash"><span class="path1"></span><span class="path2"></span></i>Tesorería</a></li>

				  </ul>
				</li>    
			  </ul>
		  </div>
		</div>
    </section>
