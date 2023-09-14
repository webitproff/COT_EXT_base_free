<!-- BEGIN: MAIN -->
<ul class="nav nav-tabs nav-stacked nav-coupon-category treeview" <!-- IF {ROW_LEVEL} == 0 -->id="selectmulticats"<!-- ENDIF -->>
	<!-- IF {ROW_LEVEL} == 0 -->
	<li><a href="{AREA|cot_url($this)}"><i class="icon-ticket"></i> {PHP.L.All}</a></li>
	<!-- ENDIF -->
	<!-- BEGIN: CATS -->
	<li<!-- IF {ROW_SELECTED} --> class="active active-my"<!-- ENDIF --><!-- IF {ROW_SUBCAT} --> data-selectmulti="{ROW_LEVEL}"<!-- ENDIF -->>
    <a href="{ROW_HREF}"><i class="icon-<!-- IF {ROW_SELECTED} -->check<!-- ELSE -->unchecked<!-- ENDIF -->"></i> <!-- IF {ROW_LEVEL} --><i class="icon-angle-right"></i><!-- ENDIF -->{ROW_TITLE}</a>
		<!-- IF {ROW_SUBCAT} -->
		{ROW_SUBCAT}
		<!-- ENDIF -->
	</li>
	<!-- END: CATS -->
</ul>
<!-- END: MAIN -->