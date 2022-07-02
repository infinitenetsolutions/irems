<!-- Footer Section Start -->
        <input type="hidden" id="checkLocation" />
        <input type="hidden" id="checkIp" />
        <footer class="main-footer" id="main_footer" style=" color : <?php if($setting->setting_theme_info->footer_color != "") echo $setting->setting_theme_info->footer_color  ?> ; background-color : <?php if($setting->setting_theme_info->footer_bg != "") echo $setting->setting_theme_info->footer_bg  ?>;">
            <strong>&copy; <?php if(date("Y") == "2020") echo "2020"; else echo "2020-".date("Y"); ?> <a href="#"  class="theme_change" id="theme_change" style="color:  <?php if($setting->setting_theme_info->ThemeChange != "") echo $setting->setting_theme_info->ThemeChange  ?> !important;"><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?></a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b title="Inventory Management System  Version 1.0">IREMS |</b> V-1.0
            </div>
        </footer>
        <!-- Footer Section End -->