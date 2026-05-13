{include file='header.tpl'}

<!-- DataTables JS -->
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>

<div class="row" id="div_print">
  <div class="col-lg-12">
    <div class="boxed">
      <div class="title-bar success">
        <h4>EXISTING SMART IDEA DETAILS</h4>
      </div>

      <div class="inner no-radius table-responsive">
        <table class="table table-striped table-bordered table-hover table-full-width" id="data-table" style="width:100%; border-collapse: collapse; font-size: 13px;">
          <thead>
            <tr style="background-color:#2c3e50; color:#FFF; text-align:center;">
              <th style="width: 50px;">SR. NO</th>
              <th style="width: 130px;">CITIZEN NAME</th>
              <th style="width: 110px;">MOBILE NO</th>
              <th style="width: 170px;">EMAIL ID</th>
              <th style="width: 180px;">ADDRESS</th>
              <th style="width: 250px;">DESCRIPTION</th>
            </tr>
          </thead>

          <tbody>
            {foreach from=$ideas_list key=id item=row name=idea}
              <tr style="word-wrap: break-word; white-space: normal; vertical-align: top;">
                <td style="text-align:center; padding:6px;">{$smarty.foreach.idea.iteration}</td>
                <td style="padding:6px;">{$row.name} - {$row.id}</td>
                <td style="padding:6px;">{$row.mobile}</td>
                <td style="padding:6px;">{$row.email}</td>
                <td style="padding:6px;">{$row.address}</td>
                <td style="padding:6px;">{$row.idea_desc}</td>
              </tr>
            {/foreach}
          </tbody>
        </table>

        {include file='footer_print.tpl'}

      </div>
    </div>
  </div>
</div>

<br><br>

{literal}
<!-- JS and Editor includes -->
<script src="assets/editors/wysihtml5/wysihtml5-0.3.0.js"></script>
<script src="assets/editors/wysihtml5/bootstrap-wysihtml5.js"></script>
<script src="assets/editors/summernote/summernote.js"></script>
<script src="assets/editors/ckeditor/ckeditor.js"></script>
<script src="js/page/editors.js"></script>

<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui-1.10.3.js"></script>
<script src="js/bootstrap-hover-dropdown.min.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/jquery.totop.js"></script>
<script src="js/main.js"></script>

<style>
  /* 🖨️ Print-friendly formatting */
  @media print {
    body {
      font-size: 12px;
      color: #000;
    }
    table {
      border: 1px solid #000;
      width: 100%;
      table-layout: fixed;
    }
    th, td {
      border: 1px solid #000 !important;
      padding: 6px;
      word-wrap: break-word;
      white-space: normal;
    }
    th {
      background-color: #e6e6e6 !important;
      color: #000 !important;
    }
    th:nth-child(1) { width: 50px !important; }
    th:nth-child(2) { width: 130px !important; }
    th:nth-child(3) { width: 110px !important; }
    th:nth-child(4) { width: 170px !important; }
    th:nth-child(5) { width: 180px !important; }
    th:nth-child(6) { width: 250px !important; }
  }
</style>
{/literal}
