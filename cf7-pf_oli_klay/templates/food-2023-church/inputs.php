<param id="type_flag" value="food-2023-church"/>
<input type="hidden" id="type_flag" name="type_flag" value="food-2023-church">
<!--<div class="row">-->
<!--    <div class="small-12 medium-4 columns">-->
<!--        <h5 class="text-uppercase">--><?//= __('Ich möchte spenden', 'donation-form') ?><!--</h5>-->
<!--    </div>-->
<!--</div>-->
<div class="row don_unique"> <!--  style="display: none;">-->

    <div class="small-12 medium-12 columns">
        <div class="row">
            <div class="small-12 medium-4 columns">
                <button class="button button-beige buttondonation" value="500" >500.- CHF</button>
            </div>
            <div class="small-12 medium-4 columns">
                <button class="button button-beige buttondonation" value="1000" >1000.- CHF</button>
            </div>
            <div class="small-12 medium-4 columns">
                <button id="default_bt_value" class="button button-beige buttondonation" value="2500" >2500.- CHF</button>
            </div>
        </div>
        <div class="row marg-top-10">
            <div class="small-12 columns ">
                <input id="wert" type="text" step="0.01" required placeholder="<? echo __('Wähle einen Betrag oder gib einen freien Betrag', 'donation-form') ?>" class="input-field buttondonationvalue" name="wert" value="<?php echo $_SESSION["fund_amount"] ?? '' ?>">
            </div>
        </div>
    </div>
</div>