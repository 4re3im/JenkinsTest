<?php

/**
 * Footer for Education Theme
 */

?>

</div>
<div class="clr empty"></div>

<div class="cup-menu-bottom-frame">
    <div class="master-frame">
        <?php // SB-246 modified by jbernardez 20190909 /?>
        <a href="<?php echo $this->url("/education/page_proofs");?>" gae-category="Footer" gae-value="Page Proofs">
            <div class="button-frame btn_view_sample_pages">
                <h3>View sample pages of new titles</h3>
            </div>
        </a>
        <?php // SB-246 modified by jbernardez 20190909 /?>
        <a href="<?php echo $this->url("/education/inspection_copy");?>" gae-category="Footer" gae-value="Inspect Copy">
            <div class="button-frame btn_order_inspection">
                <h3>Order Inspection copies of new titles</h3>
            </div>
        </a>
        <a href="http://www.cambridge.edu.au/go" gae-category="Home Outbound links" gae-value="Cambridge GO">
            <div class="button-frame end btn_cambridge_go">
                <h3>Cambridge Go</h3>
                <p>Digital resources and material</p>
            </div>
        </a>
        <div class="clr empty"></div>
    </div>

</div>
<div class="frame_content_bottom">
    <div class="content_master_block">
        <div class="section">
            <h5>Cambridge Education</h5>
            <ul>
                <li><a href="http://www.cup.co.za/?m=1">South Africa</a></li>
                <li><a href="http://education.cambridge.org/as">International Education</a></li>
                <li><a href="http://cambridgeindia.org/">India</a></li>
            </ul>
        </div>
        <div class="section">
            <h5>Visit us at</h5>
            <ul>
                <li><a href="http://www.cambridge.edu.au/go/">Cambridge GO</a></li>
                <li><a href="http://www.hotmaths.com.au/">Cambridge HOTmaths</a></li>
                <li><a href="http://www.cambridge.edu.au/checkpoints">Cambridge Checkpoints</a></li>
                <li><a href="http://www.cambridge.org/au/elt/?site_locale=en_AU">English Language Teaching</a></li>
            </ul>
        </div>
        <div class="section">
            <h5>Contact Us</h5>
            <ul>
                <li class="no_style">Ph +61 (0)3 8671 1400</li>
                <li class="no_style">1800 005 210 Free</li>
                <li><a href="mailto:enquiries@cambridge.edu.au">enquiries@cambridge.edu.au</a></li>
                <li><a href="<?php echo $this->url("/about/how-order")?>">Help</a></li>
            </ul>
        </div>
        <div class="section end">
            <h5>Follow us on</h5>
            <ul>
                <li class="twitter"><a href="https://twitter.com/Cambridge_AusEd">Twitter</a></li>
                <?php /* SB-98 modified by jbernardez 20190322 */ ?>
                <li class="youtube"><a href="http://www.youtube.com/user/CUPANZEducation">YouTube</a></li>
                <li class="facebook">
                    <a href="https://www.facebook.com/CambridgeUniversityPressEducationAustralia?ref=hl">Facebook</a>
                </li>
            </ul>
        </div>
        <div class="clr empty"></div>
    </div>
</div>
</div>

<div class="frame_footer" style="min-width:1024px;">
    <div class="clr empty"></div>
    <div class="h10 w5"></div>
    <div style="min-width:1024px;margin:0px auto; text-align: center;">
        &copy; <?php echo Date('Y');?>
        <span style="padding: 0px 10px;">|</span>
        ABN 28 508 204 178
        <span style="padding: 0px 10px;">|</span>
        <a href="<?php echo $this->url('about/terms');?>">Terms of use</a>
        <span style="padding: 0px 10px;">|</span>
        <a href="<?php echo $this->url('about/disclaimer');?>">Disclaimer</a>
        <span style="padding: 0px 10px;">|</span>
        <a href="<?php echo $this->url('about/how-order-refund-returns-policy');?>">Return & refund policy</a>
        <span style="padding: 0px 10px;">|</span>
        <a href="<?php echo $this->url('about/privacy');?>">Privacy policy</a>
        <div class="clr empty"></div>
    </div>
    <div class="h10 w5"></div>
    <div class="h20" style="background:#2e2e2e"></div>
    <div class="h20" style="background:#2e2e2e"></div>
</div>

<?php require(DIR_FILES_ELEMENTS_CORE . '/footer_required.php');?>

