<!-- BEGIN: MAIN -->

<!-- BEGIN: PAGE -->
  <h3><a href="{PHP|constant(COT_ABSOLUTE_URL)}{PAGE_ROW_URL}">{PAGE_ROW_SHORTTITLE}</a></h3>
  <!-- IF {PAGE_ROW_DESC} -->
  <p>{PAGE_ROW_DESC}</p>
  <!-- ENDIF -->
  {PAGE_ROW_TEXT_CUT}
<!-- END: PAGE -->

<!-- BEGIN: MARKET -->
  <h4>
    <!-- IF {MARKET_ROW_COST} > 0 -->
    <div>{MARKET_ROW_COST} {PHP.cfg.payments.valuta}</div>
    <!-- ENDIF --><a href="{PHP|constant(COT_ABSOLUTE_URL)}{MARKET_ROW_URL}">{MARKET_ROW_SHORTTITLE}</a>
  </h4>
  <p>
    {MARKET_ROW_OWNER_NAME}
    <span>[{MARKET_ROW_DATE}]</span> &nbsp;{MARKET_ROW_COUNTRY} {MARKET_ROW_REGION} {MARKET_ROW_CITY}
  </p>
  <p>{MARKET_ROW_SHORTTEXT}</p>
  <p><a href="{PHP|constant(COT_ABSOLUTE_URL)}{MARKET_ROW_CATURL}">{MARKET_ROW_CATTITLE}</a></p>
<!-- END: MARKET -->

<!-- END: MAIN -->