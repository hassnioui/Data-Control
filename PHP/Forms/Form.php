<?php
    class Form{

      function __construct(){}

     function formInput($type,$nom,$classe,$id,$value,$placeholder){
            $input= "<input type=$type class='$classe' id=$id name=$nom  value='$value' placeholder='$placeholder' >";
           echo $input;
            }

     function formInputDis($type,$nom,$classe,$id,$value,$placeholder,$disabled){
            $input= "<input type=$type class='$classe' id=$id name=$nom  value='$value' placeholder='$placeholder' $disabled >";
         echo $input;
            }

      function formButton($type,$nom,$classe,$id,$value,$modal,$Close){
            $button= "<button type='$type' name='$nom' class='$classe'  id='$id' data-dismiss='$modal' aria-label='$Close'>$value</button>";
            echo $button;
            }

      function formLabel($classe,$for,$value){
            $label=" <label for='$for' class='$classe'>$value</label>";
            echo $label;
            }

      function formSelectOpen($classe,$Close,$type){
            $select="<select class='$classe' aria-label='$Close' name='$type'>";
         echo $select;
            }

      function SelectOption($type,$value,$name){
            $option=" <option name='$name' value='$type'>$value</option>";
            echo $option;
            }

      function formSelectferme(){
            $selectf="</select>";
            echo $selectf;
            }

      function formCheckbox($nom,$value,$checked,$classe){
            $checkbox="<input type='checkbox' class='$classe' name='$nom' value='$value' ". ($checked ? "checked" : "") ." >";
            echo $checkbox;
            }

      function formCheckboxDis($nom,$checked,$classe,$disabled){
            $checkbox="<input type='checkbox' class='$classe' name='$nom' $disabled $checked  >";
            echo $checkbox;
            }
 
    }
?>