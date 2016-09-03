{include file='header.tpl'}

<div class="container">

  <div>
    
    <div class="col-md-2">
      <img class="img-thumbnail" style="height: 150px; width: 150px;" src="{$artist->Thumb()}"></img>
    </div>
    
    <div class="col-md-10">
      {$artist->Profile()}
    </div>
    
    
  </div>

</div>

{include file='footer.tpl'}