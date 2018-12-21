<div class="container-fluid">
    <!--套用formValidator驗證機制-->
    <{$formValidator_code}>
    <form action="<{$action}>" method="post" id="myForm" enctype="multipart/form-data" role="form">

      <!--標題-->
      <div class="row">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-sm-right">
            <{$smarty.const._MD_TADHONOR_HONOR_TITLE}>
          </label>
          <div class="col-sm-10">
            <input type="text" name="honor_title" id="honor_title" class="form-control " value="<{$honor_title}>" placeholder="<{$smarty.const._MD_TADHONOR_HONOR_TITLE}>">
          </div>
        </div>
      </div>

      <!--發佈日期-->
      <div class="row">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-sm-right">
            <{$smarty.const._MD_TADHONOR_HONOR_DATE}>
          </label>
          <div class="col-sm-4">
            <input type="text" name="honor_date" id="honor_date" class="form-control " value="<{$honor_date}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd' , startDate:'%y-%M-%d'})" placeholder="<{$smarty.const._MD_TADHONOR_HONOR_DATE}>">
          </div>

          <!--發布單位-->
          <label class="col-sm-2 col-form-label text-sm-right">
            <{$smarty.const._MD_TADHONOR_HONOR_UNIT}>
          </label>
          <div class="col-sm-4">
            <select name="honor_unit" class="form-control " size=1>
              <{foreach from=$unit_array item=unit}>
                <option value="<{$unit.name}>" <{if $honor_unit == $unit.name}>selected="selected"<{/if}>><{$unit.name}></option>
              <{/foreach}>
            </select>
          </div>
        </div>
      </div>

      <!--詳細內容-->
      <div class="row">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-sm-right">
            <{$smarty.const._MD_TADHONOR_HONOR_CONTENT}>
          </label>
          <div class="col-sm-10">
            <{$honor_content_editor}>
          </div>
        </div>
      </div>

      <!--相關連結-->
      <div class="row">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-sm-right">
            <{$smarty.const._MD_TADHONOR_HONOR_URL}>
          </label>
          <div class="col-sm-10">
            <input type="text" name="honor_url" id="honor_url" class="form-control " value="<{$honor_url}>" placeholder="<{$smarty.const._MD_TADHONOR_HONOR_URL}>">
          </div>
        </div>
      </div>

      <!--上傳-->
      <div class="row">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-sm-right">
            <{$smarty.const._MD_TADHONOR_UP_HONOR_SN}>
          </label>
          <div class="col-sm-10">
            <{$up_honor_sn_form}>
          </div>
        </div>
      </div>

      <div class="text-center">
        <{$token_form}>
        <!--編號-->
        <input type='hidden' name="honor_sn" value="<{$honor_sn}>">
        <input type="hidden" name="op" value="<{$next_op}>">
        <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
      </div>
    </form>
  </div>