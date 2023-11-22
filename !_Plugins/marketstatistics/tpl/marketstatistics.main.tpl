<!-- BEGIN: MAIN -->
<p class="uk-h5 uk-margin-small-top">
{PHP.L.marketorders_sales}: {MS_SELLS}
<!-- IF {MS_SELLS_COST} != 0 AND {PHP.usr.id} == {PHP.item.item_userid} -->
<br />
{PHP.L.marketorders_sales_summ}: {MS_SELLS_COST} <del class="uk-text-bold">P</del>
</p>
<!-- ENDIF -->
<!-- END: MAIN -->