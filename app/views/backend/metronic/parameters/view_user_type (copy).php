				<div class="col-md-12 column sortable">
					<div class="portlet portlet-sortable light bordered">
						<div class="portlet-title tabbable-line">
							<div class="caption">
								<i class="icon-puzzle font-red-flamingo"></i>
								<span class="caption-subject bold font-red-flamingo uppercase">
								User Type </span>
							</div>
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#portlet_tab_lists" data-toggle="tab">
									Lists </a>
								</li>
								<li>
									<a href="#portlet_tab_form" data-toggle="tab">
									Form </a>
								</li>
							</ul>
						</div>
						<div class="portlet-body">
							<div class="tab-content">
								<div class="tab-pane active" id="portlet_tab_lists">
									
									
									
									
									
									<div class="portlet">
										<div class="portlet-title">
											<div class="caption">
												<i class="fa fa-shopping-cart"></i>Order Listing
											</div>
											<div class="actions">
												<a href="#" class="btn default yellow-stripe">
												<i class="fa fa-plus"></i>
												<span class="hidden-480">
												New Order </span>
												</a>
												<div class="btn-group">
													<a class="btn default yellow-stripe" href="#" data-toggle="dropdown">
													<i class="fa fa-share"></i>
													<span class="hidden-480">
													Tools </span>
													<i class="fa fa-angle-down"></i>
													</a>
													<ul class="dropdown-menu pull-right">
														<li>
															<a href="#">
															Export to Excel </a>
														</li>
														<li>
															<a href="#">
															Export to CSV </a>
														</li>
														<li>
															<a href="#">
															Export to XML </a>
														</li>
														<li class="divider">
														</li>
														<li>
															<a href="#">
															Print Invoices </a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="portlet-body">
											<div class="table-container">
												<div class="table-actions-wrapper">
													<span>
													</span>
													<select class="table-group-action-input form-control input-inline input-small input-sm">
														<option value="">Select...</option>
														<option value="Cancel">Cancel</option>
														<option value="Cancel">Hold</option>
														<option value="Cancel">On Hold</option>
														<option value="Close">Close</option>
													</select>
													<button class="btn btn-sm yellow table-group-action-submit"><i class="fa fa-check"></i> Submit</button>
												</div>
												<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
												<thead>
												<tr role="row" class="heading">
													<th width="2%">
														<input type="checkbox" class="group-checkable">
													</th>
													<th width="5%">
														 Record&nbsp;#
													</th>
													<th width="15%">
														 Date
													</th>
													<th width="15%">
														 Customer
													</th>
													<th width="10%">
														 Ship&nbsp;To
													</th>
													<th width="10%">
														 Price
													</th>
													<th width="10%">
														 Amount
													</th>
													<th width="10%">
														 Status
													</th>
													<th width="10%">
														 Actions
													</th>
												</tr>
												<tr role="row" class="filter">
													<td>
													</td>
													<td>
														<input type="text" class="form-control form-filter input-sm" name="order_id">
													</td>
													<td>
														<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
															<input type="text" class="form-control form-filter input-sm" readonly name="order_date_from" placeholder="From">
															<span class="input-group-btn">
															<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
															</span>
														</div>
														<div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
															<input type="text" class="form-control form-filter input-sm" readonly name="order_date_to" placeholder="To">
															<span class="input-group-btn">
															<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
															</span>
														</div>
													</td>
													<td>
														<input type="text" class="form-control form-filter input-sm" name="order_customer_name">
													</td>
													<td>
														<input type="text" class="form-control form-filter input-sm" name="order_ship_to">
													</td>
													<td>
														<div class="margin-bottom-5">
															<input type="text" class="form-control form-filter input-sm" name="order_price_from" placeholder="From"/>
														</div>
														<input type="text" class="form-control form-filter input-sm" name="order_price_to" placeholder="To"/>
													</td>
													<td>
														<div class="margin-bottom-5">
															<input type="text" class="form-control form-filter input-sm margin-bottom-5 clearfix" name="order_quantity_from" placeholder="From"/>
														</div>
														<input type="text" class="form-control form-filter input-sm" name="order_quantity_to" placeholder="To"/>
													</td>
													<td>
														<select name="order_status" class="form-control form-filter input-sm">
															<option value="">Select...</option>
															<option value="pending">Pending</option>
															<option value="closed">Closed</option>
															<option value="hold">On Hold</option>
															<option value="fraud">Fraud</option>
														</select>
													</td>
													<td>
														<div class="margin-bottom-5">
															<button class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search"></i> Search</button>
														</div>
														<button class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i> Reset</button>
													</td>
												</tr>
												</thead>
												<tbody>
												</tbody>
												</table>
											</div>
										</div>
									</div>
									
									
									
									
									
									
									
									
								</div>
								<div class="tab-pane" id="portlet_tab_form">
									<h4>User Type Form</h4>
									<p>
										 
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
