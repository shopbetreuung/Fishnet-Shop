UPDATE database_version SET version = 'SH_1.10.0';

UPDATE email_manager SET em_body = '<table width="100%" cellspacing="0" cellpadding="4" border="0" align="center">
    <tbody>
        <tr>
            <td style="border-bottom: 1px solid; border-color: #cccccc;">
            <div align="right"><img src="{$logo_path}logo.gif" alt="" /></div>
            </td>
        </tr>
        <tr>
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Dear customer, </strong><br />
            <br />
            the attachment of this e-Mail includes the invoice of your order from {$ORDER_DATE}.<br />
            <br />
            The state of your order you can inspect under: <a href="{$ORDER_LINK}">{$ORDER_LINK}</a>.<br />
            </font></td>
        </tr>
    </tbody>
</table>' WHERE em_name = 'invoice_mail' AND em_language = '1';

