<!-- Footer Section Start -->
        <input type="hidden" id="checkLocation" />
        <input type="hidden" id="checkIp" />
        <input type="hidden" id="streamConfCheck" value="inactive" />
        <footer class="main-footer" id="main-footer">
            <strong>&copy; <?php if(date("Y") == "2020") echo "2020"; else echo "2020-".date("Y"); ?> <a href="#"><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?></a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b title="IREMS Portal | Developed By  Infinite Net Solutions | Version 1.0">IREMS |</b> V-1.0
            </div>
        </footer>
        <!-- Footer Section End -->
    