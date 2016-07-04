<?php
    //Before outputing form elements
    $form->setElementDecorators(array('ViewHelper'));
?>
<!-- 
    This is all for:
    <input type="text">
    <textarea>
    <select>

    Just paste code below:
-->

<?php
    echo $form->getElement('fieldName')->setAttribs(array(
        'class' => 'form-control'
    ));
?>


<!--
    This is for radio:
-->
    <div class="radio">
        <?php
        echo $form->getElement('fieldName')->setAttribs(array(
            'label_class' => ''
        ))->setSeparator('</div><div class=radio>');
        ?>
    </div>

<!--
    This is for inline radio:
-->
<?php
    echo $form->getElement('fieldName')->setAttribs(array(
        'label_class' => 'radio-inline'
    ))->setSeparator('');
?>

<!--
    This is for multicheckbox:
-->
    <div class="checkbox">
        <?php
        echo $form->getElement('fieldName')->setAttribs(array(
            'label_class' => ''
        ))->setSeparator('</div><div class=checkbox>');
        ?>
    </div>


<!--
    This is for inline multicheckbox:
-->
<?php
    echo $form->getElement('fieldName')->setAttribs(array(
        'label_class' => 'checkbox-inline'
    ))->setSeparator('');
?>

<!-- 

    field errors template
-->
    <?php if ($form->getElement('fieldName')->hasErrors()) { ?>
        <div class="has-error">
            <?php foreach ($form->getElement('fieldName')->getMessages() as $message) { ?>
                <p class="help-block"><?php echo $this->escape($message); ?></p>
            <?php } ?>
        </div>
    <?php } ?>


