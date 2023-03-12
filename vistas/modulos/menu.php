<aside class="main-sidebar">
	<section class="sidebar">
		<ul class="sidebar-menu">
		<?php
		if($_SESSION["perfil"] == "Administrador"){
			echo 	'<li class="active">
						<a href="inicio">
							<i class="fa-solid fa-house"></i>
							<span>Inicio</span>
						</a>
					</li>
					
					<li class="treeview">
						<a href="#">
							<i class="fa fa-user"></i>
							<span>Usuarios</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>

						<ul class="treeview-menu">
							<li>
								<a href="usuarios">
									<i class="fa fa-user"></i>
									<span>Usuarios</span>
								</a>
							</li>
							<li>
								<a href="asignar-depositos-usuario">
									<i class="fa fa-user"></i>
									<span>Usuarios Depósitos</span>
								</a>
							</li>
						</ul>
					</li>';
		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Especial"){
			echo 	'<li class="treeview">
						<a href="#">
							<i class="fa fa-barcode"></i>
							<span>Productos</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li>
								<a href="productos">	
									<i class="fa-solid fa-check"></i>
									<span>Lista de Productos</span>
								</a>
							</li>
							<li>
								<a href="categorias">	
									<i class="fa-solid fa-check"></i>
									<span>Lista de Categorías</span>
								</a>
							</li>
							<li>
								<a href="marcas">	
									<i class="fa-solid fa-check"></i>
									<span>Lista de Marcas</span>
								</a>
							</li>
							<li>
								<a href="unidades">	
									<i class="fa-solid fa-check"></i>
									<span>Lista de Unidades</span>
								</a>
							</li>
							<li>
								<a href="colores">	
									<i class="fa-solid fa-check"></i>
									<span>Lista de Colores</span>
								</a>
							</li>
							<li>
								<a href="calces">	
									<i class="fa-solid fa-check"></i>
									<span>Lista de Calces</span>
								</a>
							</li>
						</ul>
					</li>';
		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Especial"){
			echo 	'<li class="treeview">
						<a href="#">
							<i class="fa fa-recycle"></i>
							<span>Transferencias</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li>
								<a href="depositos">	
									<i class="fa-solid fa-check"></i>
									<span>Depósitos</span>
								</a>
							</li>
							<li>
								<a href="transferencias">	
									<i class="fa-solid fa-check"></i>
									<span>Transferencias</span>
								</a>
							</li>
						</ul>
					</li>';
		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){
			echo   '<li class="treeview">
						<a href="#">
							<i class="fa fa-users"></i>
							<span>Clientes</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li>
								<a href="clientes">	
									<i class="fa-solid fa-check"></i>
									<span>Lista de Clientes</span>
								</a>
							</li>
							<li>
								<a href="cumpleanios">	
									<i class="fa-solid fa-check"></i>
									<span>Lista de Cumpleaños</span>
								</a>
							</li>
							<li>
								<a href="gruposcliente">	
									<i class="fa-solid fa-check"></i>
									<span>Grupo de Clientes</span>
								</a>
							</li>

						</ul>
					</li>';
		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){
			echo   '<li class="treeview">
						<a href="#">
							<i class="fa fa-truck"></i>
							<span>Proveedores</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li>
								<a href="proveedores">	
									<i class="fa-solid fa-check"></i>
									<span>Lista de Proveedores</span>
								</a>
							</li>
						</ul>
					</li>';
		}

		if($_SESSION["perfil"] == "Administrador"){
			echo   '<li class="treeview">
						<a href="#">
							<i class="fa-solid fa-money-bill-1-wave"></i>
							<span>Gastos</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li>
								<a href="categoriagastos">	
									<i class="fa-solid fa-check"></i>
									<span>Categoría de Gastos</span>
								</a>
							</li>
						</ul>
					</li>';
		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){
			echo 	'<li class="treeview">
						<a href="#">
							<i class="fa-solid fa-cart-shopping"></i>
							<span>Ventas</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li>
								<a href="ventas">	
									<i class="fa-solid fa-check"></i>
									<span>Administrar ventas</span>
								</a>
							</li>
							<li>
								<a href="crear-venta">	
									<i class="fa-solid fa-check"></i>
									<span>Crear venta</span>
								</a>
							</li>';

					if($_SESSION["perfil"] == "Administrador"){
					echo 	'<li>
								<a href="reportes">
									<i class="fa-solid fa-check"></i>
									<span>Reporte de ventas</span>
								</a>
								<a href="control-ventas">
									<i class="fa-solid fa-check"></i>
									<span>Control de Ventas </span>
								</a>
								<a href="terminos-pago">
									<i class="fa-solid fa-check"></i>
									<span>Términos de Pagos</span>
								</a>
								<a href="cajas">
									<i class="fa-solid fa-check"></i>
									<span>Cajas</span>
								</a>
								<a href="sucursales">
									<i class="fa-solid fa-check"></i>
									<span>Sucursales</span>
								</a>
							</li>';
				echo '</ul>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="fa-solid fa-cash-register"></i>
							<span>Cajas</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li>
								<a href="aperturas">
									<i class="fa-solid fa-check"></i>
									<span>Apertura de Cajas</span>
								</a>
							</li>
							<li>
								<a href="cierre-cajas">
									<i class="fa-solid fa-check"></i>
									<span>Cierre de Cajas</span>
								</a>
							</li>';
				echo 	'</ul>
					</li>';
		}

		if($_SESSION["perfil"] == "Administrador" ){
			echo 	'<li class="treeview">
						<a href="#">
							<i class="fa-solid fa-wallet"></i>
							<span>Compras</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li>
								<a href="compras">	
									<i class="fa-solid fa-check"></i>
									<span>Administrar Compras</span>
								</a>
							</li>
							<li>
								<a href="crear-compra">	
									<i class="fa-solid fa-check"></i>
									<span>Crear Compra</span>
								</a>
							</li>
						</ul>
					</li>';
		}

		if($_SESSION["perfil"] == "Administrador" ){
			echo 	'<li class="treeview">
						<a href="#">
							<i class="fa-solid fa-dolly"></i>
							<span>Transferencias</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li>
								<a href="transferencias">	
									<i class="fa-solid fa-check"></i>
									<span>Listar Transferencias</span>
								</a>
							</li>
							<li>
								<a href="crear-transferencia">	
									<i class="fa-solid fa-check"></i>
									<span>Crear Transferencia</span>
								</a>
							</li>
						</ul>
					</li>';
		}
		

	}
		?>
		</ul>
	 </section>
</aside>
