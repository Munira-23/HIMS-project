<!-- Header -->

<div class="header">
			
	<!-- Logo -->
	<div class="header-left">
		<a href="{{route('dashboard')}}" class="logo">
			<img src="@if(!empty(AppSettings::get('logo'))) {{asset('storage/'.AppSettings::get('logo'))}} @else{{asset('assets/img/logo.png')}} @endif" alt="Logo">
			<span style="font-size: 18px; font-weight: bold; color: #4682B4;">Inventory</span>

		</a>
		<a href="{{route('dashboard')}}" class="logo logo-small">
			<img src="logo.png" alt="Logo" width="30" height="30">
		</a>
	</div>
	<!-- /Logo -->
	
	<a href="javascript:void(0);" id="toggle_btn">
		<i class="fe fe-text-align-left"></i>
	</a>
	
	<!-- Visit codeastro.com for more projects -->
	<!-- Mobile Menu Toggle -->
	<a class="mobile_btn" id="mobile_btn">
		<i class="fa fa-bars"></i>
	</a>
	<!-- /Mobile Menu Toggle -->
	
	<!-- Header Right Menu -->
	<ul class="nav user-menu">
		<li class="nav-item dropdown">
			
		</li>
		<!-- Notifications -->
		<li class="nav-item dropdown noti-dropdown">
			
			<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
				<i class="fe fe-bell"></i> <span class="badge badge-pill">{{auth()->user()->unReadNotifications->count()}}</span>
			</a>
			<div class="dropdown-menu notifications">
				<div class="topnav-dropdown-header">
					<span class="notification-title">Notifications</span>
					<a href="{{route('mark-as-read')}}" class="clear-noti">Mark All As Read </a>
				</div>
				<div class="noti-content">
					<ul class="notification-list">
						@foreach (auth()->user()->unReadNotifications as $notification)
							<li class="notification-message">
								<a href="{{route('read')}}">
									<div class="media">
									<span class="avatar avatar-sm bg-danger-light text-danger mr-2 d-flex align-items-center justify-content-center">
                                        <i class="fe fe-bell"></i>
                                       </span>

										<div class="media-body">
										@if ($notification->type === 'App\\Notifications\\StockAlertNotification')
										<h6 class="text-danger">Stock Alert</h6>
										<p class="noti-details">
											<span class="noti-title">
												{{ $notification->data['product_name'] }} is only {{ $notification->data['quantity'] ?? 'N/A' }} left.
											</span>
											<br>
											<span>Please update the Stock quantity</span>
										</p>
									@elseif ($notification->type === 'App\\Notifications\\ProductExpiredNotification')
										<h6 class="text-danger">Expired Product Alert</h6>
										<p class="noti-details">
											<span class="noti-title">
												{{ $notification->data['product_name'] }} expired on {{ $notification->data['expiry_date'] }}
											</span>
											<br>
											<span>Please remove or restock accordingly</span>
										</p>
									@endif

									<p class="noti-time">
										<span class="notification-time">
											{{ $notification->created_at->diffForHumans() }}
										</span>
									</p>
								</div>
							</div>
						</a>
					</li>
				@endforeach											
					</ul>
				</div>
				<div class="topnav-dropdown-footer">
					<a href="#">View all Notifications</a>
				</div>
			</div>
		</li>
		<!-- /Notifications -->
		
		<!-- User Menu -->
		<li class="nav-item dropdown has-arrow">
			<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
				<span class="user-img"><img class="rounded-circle" src="{{!empty(auth()->user()->avatar) ? asset('storage/users/'.auth()->user()->avatar): asset('assets/img/avatar_1nn.png')}}" width="31" alt="avatar"></span>
			</a>
			<div class="dropdown-menu">
				<div class="user-header">
					<div class="avatar avatar-sm">
						<img src="{{!empty(auth()->user()->avatar) ? asset('storage/users/'.auth()->user()->avatar): asset('assets/img/avatar_1nn.png')}}" alt="User Image" class="avatar-img rounded-circle">
					</div>
					<div class="user-text">
						<h6>{{auth()->user()->name}}</h6>
					</div>
				</div>
				
				<a class="dropdown-item" href="{{route('profile')}}">My Profile</a>
				@can('view-settings')<a class="dropdown-item" href="{{route('settings')}}">Settings</a>@endcan
				
				<a href="javascript:void(0)" class="dropdown-item">
					<form action="{{route('logout')}}" method="post">
					@csrf
					<button type="submit" class="btn">Logout</button>
				</form>
				</a>
			</div>
		</li>
		<!-- /User Menu -->
		
	</ul>
	<!-- /Header Right Menu -->
	
</div>
<!-- /Header -->