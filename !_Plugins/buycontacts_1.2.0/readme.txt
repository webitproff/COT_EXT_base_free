<!-- IF {PRJ_PERFORMER} == {PHP.usr.profile.user_id} -->
            <!-- IF {PRJ_ID|cot_contact_isbought($this)} -->
                {PRJ_CONTACTS_FOR_BUY}
            <!-- ELSE -->       
                <a href="{PRJ_BUY_CONTACT_URL}" class="btn btn-info">{PHP.L.buy_contact} за {PRJ_ID|cot_contact_getcost($this)} {PHP.cfg.payments.valuta}</a>
            <!-- ENDIF -->
        <!-- ENDIF -->