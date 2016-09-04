{include file='header.tpl'}

<div class="container">

  <div>
    
    <div class="row">
      <div class="col-md-2">
        <img class="img-thumbnail" style="height: 150px; width: 150px;" src="{$artist->Thumb()}"></img>
      </div>

      <div class="col-md-10">
        {$artist->Profile()}
      </div>
    </div>
    
    <div class="row">
      {foreach $artist->Releases() as $release}
      <div class="col-sm-3 col-sm-offset-1">
        <div>
          <a><img src="{$release['thumb']}" class="img-thumbnail" style="height:150px; width:150px;"></a>
        </div>
        {$release['title']}
      </div>
      {/foreach}
    </div>
    
    
  </div>

</div>

{include file='footer.tpl'}