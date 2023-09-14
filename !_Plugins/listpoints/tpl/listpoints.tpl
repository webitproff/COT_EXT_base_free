<!-- BEGIN: MAIN -->
<div class="breadcrumb">{PHP.L.ListPoints}</div>
	<h1>{PHP.L.ListPoints}</h1>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <td>{PHP.L.Date}</td>
          <td>{PHP.L.Type}</td>
          <td>{PHP.L.Rating}</td>
        </tr>
      </thead>
	<!-- BEGIN: POINTS_AUTH -->
        <tr>
          <th>-</th>
          <td>-</td>
          <td>{PHP.L.listpoints_allauth}</td>
          <td>+ {POINTS_ROW_AUTH_COUNT}</td>
        </tr>
	<!-- END: POINTS_AUTH -->
	<!-- BEGIN: POINTS -->
        <tr>
          <th>{POINTS_ROW_NUM}</th>
          <td>{POINTS_ROW_DATE}</td>
          <td>{POINTS_ROW_TYPE}</td>
          <td>{POINTS_ROW_POS} {POINTS_ROW_COUNT}</td>
        </tr>
	<!-- END: POINTS -->
      </tbody>
    </table>
<!-- END: MAIN -->