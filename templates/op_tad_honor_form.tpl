<div class="container-fluid">
    <form action="<{$smarty.server.PHP_SELF}>" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal" role="form">

      <!--標題-->
      <div class="form-group row mb-3">
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
          <{$smarty.const._MD_TADHONOR_HONOR_TITLE}>
        </label>
        <div class="col-sm-10">
          <input type="text" name="honor_title" id="honor_title" class="form-control " value="<{$honor_title|default:''}>" placeholder="<{$smarty.const._MD_TADHONOR_HONOR_TITLE}>">
        </div>
      </div>

      <!--發佈日期-->
      <div class="form-group row mb-3">
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
          <{$smarty.const._MD_TADHONOR_HONOR_DATE}>
        </label>
        <div class="col-sm-4">
          <input type="text" name="honor_date" id="honor_date" class="form-control " value="<{$honor_date|default:''}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd' , startDate:'%y-%M-%d'})" placeholder="<{$smarty.const._MD_TADHONOR_HONOR_DATE}>">
        </div>

        <!--發布單位-->
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
          <{$smarty.const._MD_TADHONOR_HONOR_UNIT}>
        </label>
        <div class="col-sm-4">
          <select name="honor_unit" class="form-control form-select " size=1>
            <{foreach from=$unit_array item=unit}>
              <option value="<{$unit.name}>" <{if $honor_unit == $unit.name}>selected="selected"<{/if}>><{$unit.name}></option>
            <{/foreach}>
          </select>
        </div>
      </div>

      <!--詳細內容-->
      <div class="form-group row mb-3">
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
          <{$smarty.const._MD_TADHONOR_HONOR_CONTENT}>
        </label>
        <div class="col-sm-10">
          <{$honor_content_editor|default:''}>
        </div>
      </div>

      <!--相關連結-->
      <div class="form-group row mb-3">
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
          <{$smarty.const._MD_TADHONOR_HONOR_URL}>
        </label>
        <div class="col-sm-10">
          <input type="text" name="honor_url" id="honor_url" class="form-control " value="<{$honor_url|default:''}>" placeholder="<{$smarty.const._MD_TADHONOR_HONOR_URL}>">
        </div>
      </div>

      <!--上傳-->
      <div class="form-group row mb-3">
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
          <{$smarty.const._MD_TADHONOR_UP_HONOR_SN}>
        </label>
        <div class="col-sm-10">
          <{$up_honor_sn_form|default:''}>
        </div>
      </div>

      <div class="text-center">
        <{$token_form|default:''}>
        <!--編號-->
        <input type='hidden' name="honor_sn" value="<{$honor_sn|default:''}>">
        <input type="hidden" name="op" value="<{$next_op|default:''}>">
        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-disk" aria-hidden="true"></i> <{$smarty.const._TAD_SAVE}></button>
      </div>
    </form>
  </div>