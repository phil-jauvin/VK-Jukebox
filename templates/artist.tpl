{include file='header.tpl'}

<div class="container">

  <div>
    
    <div class="row" style="margin-top: 10vh; border-radius: 25px; border: 2px solid lightgray; padding: 20px; ">
      <div class="col-md-2">
        <img class="img-thumbnail" style="height: 150px; width: 150px;" src="{$artist->Thumb()}"></img>
      </div>

      <div class="col-md-10">
        {$artist->Profile()}
      </div>
    </div>
    
    <div class="row" style="margin-top: 25vh;">
      {foreach $artist->Releases() as $release}
      <div class="col-sm-3 col-sm-offset-1">
        <div>
          <img src="{if !empty($release['thumb'])}{$release['thumb']}{else}/templates/img/default-release.png{/if}" class="img-thumbnail" style="height:150px; width:150px;">
        </div>
        {$release['title']}
      </div>
      {/foreach}
    </div>
    
    
  </div>

</div>

{include file='footer.tpl'}