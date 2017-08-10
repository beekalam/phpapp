<?php
echo "test";
exit;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card-box tilebox-one">
            <i class="icon-basket-loaded pull-xs-left text-muted"></i>
            <h6 class="header-title m-t-0 m-b-20" style="margin-bottom:20px!important; "> مرور صورتحاسب فروش خدمات </h6>

            <div class="row" style="margin-top:15px; border-top: 1px dotted #aaa; padding-top: 15px;">
                <div style="width: 100%; text-align: center; position: relative">
                    <!--<img src="inc/ux_vendor/ashkan/images/paid.png" style="position: absolute; bottom: 20px; right: 300px; max-width: 200px;"/>-->
                    <div id="user_factor">
                        <div class="row">
                            <div id="chart1-right" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style=" vertical-align: top">

                                <table style="min-width: 500px; max-width: 900px" align="center" class="factor_table">
                                    <tr>
                                        <td colspan="5" class="factor_header_td" >
                                            <table width="100%">
                                                <tr>
                                                    <td colspan="2" class="factor_header_text_td">
                                                        صورت وضعیت کاربر
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table style="width:100%;">
                                                            <tr>
                                                                <td style="width: 120px" class="factor_text_td">
                                                                    شماره صورت وضعیت :
                                                                </td>
                                                                <td class="persian_digits factor_value_td">
                                                                    <?php echo $ui["factor"]["id"]; ?>
                                                                    {{ @vm['id'] }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table style="width:100%;">
                                                            <tr>
                                                                <td style="text-align: left" class="factor_text_td">
                                                                    تاریخ صدور :
                                                                </td>
                                                                <td class="persian_digits factor_value_td" style="text-align: left; width: 100px;">
                                                                    {{  @vm['date'] }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <!--
                                                <tr>
                                                    <td colspan="2" class="factor_line" style=" height: 5px;"></td>
                                                </tr>
                                                -->
                                                <tr>
                                                    <td>
                                                        <table style="width:100%">
                                                            <tr>
                                                                <td style="width: 120px" class="factor_text_td">
                                                                    نام مشترک :
                                                                </td>
                                                                <td class="persian_digits factor_value_td">
                                                                    <?php
                                                                if ($ui["user"]["gender"] != "")
                                                                    echo $ui["user"]["gender"]." ";

                                                                if (($ui["user"]["fname"] != "") or ($ui["user"]["lname"] != ""))
                                                                    echo $ui["user"]["fname"]." ".$ui["user"]["lname"];
                                                                elseif ($ui["user"]["full_name"])
                                                                    echo $ui["user"]["full_name"];
                                                                ?>
                                                                    {{ @vm[fullname] }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 120px" class="factor_text_td">
                                                                    آدرس مشترک :
                                                                </td>
                                                                <td class="persian_digits factor_value_td">
                                                                    <?php echo $ui["user"]["user_address"]; ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table style="width:100%">
                                                            <tr>
                                                                <td style="text-align:left" class="factor_text_td">
                                                                    کد مشترک :
                                                                </td>
                                                                <td class="persian_digits factor_value_td" style="text-align:left; width: 100px;">
                                                                    <?php echo $ui["user"]["user_id"]; ?>
                                                                    {{@vm['user_id']}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align:left" class="factor_text_td">
                                                                    تلفن مشترک :
                                                                </td>
                                                                <td class="persian_digits factor_value_td" style="text-align: left; width: 100px;">
                                                                    <?php echo $ui["user"]["mobile_number"];//." ".$ui["user"]["phone_number"]; ?>
                                                                    {{ @vm['mobile_number'] }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <!--
                                                <tr>
                                                    <td colspan="2" class="factor_line" style=" height: 5px;"></td>
                                                </tr>
                                                -->
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="factor_rows_td" style="width: 50px; ">
                                            ردیف
                                        </td>
                                        <td class="factor_rows_td" id="sharh_td">
                                            شـــــرح
                                        </td>
                                        <td class="factor_rows_td" style="width: 100px">
                                            مبلغ
                                        </td>
                                        <td class="factor_rows_td" style="width: 60px">
                                            تعداد
                                        </td>
                                        <td class="factor_rows_td" style="width: 120px">
                                            مبلغ ردیف
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="factor_rows_td persian_digits" style="width:50px; ">
                                            1
                                        </td>
                                        <td class="factor_rows_td persian_digits">
                                            <?php echo $ui["factor"]["details"]["package_nikname"]; ?>
                                            {{@vm['details.package_nikname']}}
                                        </td>
                                        <td class="factor_rows_td persian_digits" style="width:100px">
                                            <?php
                                            $to_print = $ui["factor"]["details"]["absolute_package_fi"];
                                            if (intval($ui["factor"]["details"]["promotion_price"]) > 0)
                                                $to_print = $to_print - intval($ui["factor"]["details"]["promotion_price"]);
                                                 echo number_format($to_print).' ریال ';
                                            ?>
                                            {{ number_format(@vm['details.absolute_package_fi']) }} ریال
                                        </td>
                                        <td class="factor_rows_td persian_digits" style="width: 60px">
                                            <?php
                                            echo '1';
                                        ?>
                                            1
                                        </td>
                                        <td class="factor_rows_td persian_digits" style="width: 120px">
                                            <?php
                                                   echo number_format($to_print).' ریال ';
                                              ?>
                                            {{ @absolute_package_fi_minus_promotion_price }}
                                        </td>
                                    </tr>

                                    <?php if (intval($ui["factor"]["details"]["promotion_price"]) > 0) { ?>

                                    <tr>
                                        <td class="factor_rows_tdb" colspan="2">
                                            <?php
                                        echo ' شرح تخفیف : '.$ui["factor"]["discount_comments"];
                                        ?>
                                            {{ @vm['details.discount_comments'] }}
                                        </td>
                                        <td class="factor_rows_tdb" colspan="2"  style="text-align: left" >
                                            تخفیف :
                                        </td>
                                        <td class="factor_rows_tdb persian_digits" style="width: 120px">
                                            <?php
                                        echo $ui["factor"]["discount"];
                                        ?>
                                            {{ @vm['details.discount'] }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="factor_rows_tdb" colspan="2" >
                                            <?php
                                        echo $ui["factor"]["details"]["bestan_comments"];
                                    ?>
                                            {{ @vm['details.bestan_comments'] }}
                                        </td>
                                        <td class="factor_rows_tdb" colspan="2" style="text-align: left" >
                                            بستانکاری :
                                        </td>
                                        <td class="factor_rows_tdb persian_digits" style="width: 120px">
                                            <?php
                                        echo number_format( intval($ui["factor"]["details"]["user_bes_before_factor"]) +
                                            intval($ui["factor"]["details"]["user_current_package_value"])).' ریال ';
                                    ?>
                                            {{ number_format(intval(@vm['details.user_bes_before_factor'])) +
                                                intval(@vm['details.user_current_package_value']) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="factor_rows_tdb" colspan="2" >
                                            <?php
                                        echo $ui["factor"]["details"]["bedehi_comments"];
                                    ?>
                                            {{ @vm['details.bedehi_comments'] }}
                                        </td>
                                        <td class="factor_rows_tdb" colspan="2" style="text-align: left" >
                                            بدهکاری :
                                        </td>
                                        <td class="factor_rows_tdb persian_digits" style="width: 120px">
                                            <?php
                                        echo number_format(intval($ui["factor"]["details"]["user_bed_before_factor"])).' ریال ';
                                    ?>
                                            {{ intval(@vm['details.user_bed_before_factor']) }} ریال
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="5" class="factor_footer_td">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="factor_rows_tdb persian_digits" colspan="2">
                                            <?php
                                    echo 'شرح صورت وضعیت :';
                                    echo $ui["factor"]["details"]["factor_comments"];
                                    ?>
                                            شرح صورت وضعیت :
                                    {{ @vm['details.factor_comments'] }}
                                        </td>
                                        <td class="factor_rows_tdb" colspan="2" style="text-align: left" >
                                            قابل پرداخت :
                                        </td>
                                        <td class="factor_rows_tdb persian_digits" style="width: 120px">
                                            <?php
                                        echo number_format(intval($ui["factor"]["details"]["to_pay"])).' ریال ';
                                    ?>
                                            {{ number_format(@vm['details.to_pay']) }} ریال
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="5" class="factor_footer_td">

                                        </td>
                                    </tr>
                                </table>

                                <div style="text-align: left">
                                    <!--number_format($ui["factor"]["details"]["final_amount_to_pay_to_reseller"]).-->
                                     مبلغ منظور شده به حساب عامل فروش بابت این صورت وضعیت: <span style="font-weight:bold; color:blue">
                                            {{ number_format(@vm['details.final_amount_to_pay_to_reseller']) }}
                                    </span> ریال
                                    <br>
                                    <!--number_format($ui["factor"]["details"]["wholesale_price"]).-->
                                    بهای تمام شده این صورت وضعیت برای عامل فروش: <span style="font-weight:bold; color:red">
                                     {{ number_format(@vm['details.wholesale_price']) }}
                                    </span> ریال
                                </div>
                            </div>
                        </div>

                        <!-- <img src="<?php echo WEB_ROOT; ?>inc/ux_vendor/ashkan/images/paid.png" style="position: absolute; top: 50px; opacity: .8; margin:0 auto; left:0px; right: 0px;" /> -->

                    </div>

                    <check if="{{  @show_requested_btn_reseller }}">

                        <true>
                            <button id="request" name="request" class="btn btn-success">درخواست صدور صورت وضعیت رسمی </button>
                            <script>
                                $(document).ready(function(){
                                    var to_send = {};
                                    to_send.invoiceid = "{{ @vm[id] }}";
                                    $("#request").click(function ()
                                    {
                                        $.ajax({
                                            url:"{{@BASE}}/official-invoice",
                                            type:'POST',
                                            data: to_send
                                        }).done(function(data){
                                            data = JSON.parse(data);
                                            if(data["success"])
                                            {
                                                swal({
                                                    type: "success",
                                                    title: "درخواست با موفقیت ثبت شد.",
                                                    showLoaderOnConfirm: true,
                                                    confirmButtonText:"بازگشت",
                                                    confirmButtonColor:"#1bb99a"
                                                }).then(function() {
                                                    location.reload();
                                                });
                                            }
                                            else
                                            {
                                                swal({
                                                    type: "error",
                                                    title: "خطا ثبت درخواست",
                                                    showLoaderOnConfirm: true,
                                                    confirmButtonText:"بازگشت",
                                                    confirmButtonColor:"#1bb99a"
                                                }).then(function() {
                                                    location.reload();
                                                });
                                            }

                                            console.log(data);
                                        });
                                    });
                                }); //document.ready
                            </script>
                        </true>

                    </check>

                    <check if="{{  @show_requested_btn_sup }}">

                        <true>
                            <div> درخواست صدور صورت وضعیت رسمی از طرف کاربر:
                                {{ @vm['details.official_request_admin'] }}</div>
                            <br/>
                            <button id="sup-accept" name="request" class="btn btn-success">قبول درخواست</button>
                            <script>
                                $(document).ready(function(){
                                    var to_send = {};
                                    to_send.invoiceid = "{{ @vm[id] }}";

                                    $("#sup-accept").click(function () {
                                        $.ajax({
                                            url: "{{@BASE}}/invoice-request-accept",
                                            type: 'POST',
                                            data: to_send
                                        }).done(function (data) {
                                            data = JSON.parse(data);
                                            if(data["success"]){
                                                swal({
                                                    type: "success",
                                                    title: "درخواست با موفقیت ثبت شد.",
                                                    showLoaderOnConfirm: true,
                                                    confirmButtonText:"بازگشت",
                                                    confirmButtonColor:"#1bb99a"
                                                }).then(function() {
                                                    location.reload();
                                                });
                                            }else{
                                                swal({
                                                    type: "error",
                                                    title: "خطا ثبت درخواست",
                                                    showLoaderOnConfirm: true,
                                                    confirmButtonText:"بازگشت",
                                                    confirmButtonColor:"#1bb99a"
                                                }).then(function() {
                                                    location.reload();
                                                });
                                            }
                                        });
                                    });
                                }); //document.ready
                            </script>
                        </true>
                    </check>

                    <check if="{{ @show_sent }}">
                        <true>
                            <div style="font-size:18px;color:red;"> درخواست صدور صورت وضعیت ثبت شده است.</div>
                        </true>
                    </check>

                    <div id="ajax-content2"></div>

                </div>
            </div>
        </div>
    </div>
