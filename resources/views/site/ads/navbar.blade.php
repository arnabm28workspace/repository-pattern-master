 <div class="row">
   <div class="col-12">
    <ul class="nav mt-2 mt-md-0 mb-2 mb-md-4 nav-wizard">
         <li class="{{ ( (Route::currentRouteName() == 'user.post.ad') || (Route::currentRouteName() == 'user.post.edit.ad') ) ? 'active' : '' }}">
         <a href="#">Details</a>
         </li>
         <li class="{{ ( (Route::currentRouteName() == 'checkout') || (Route::currentRouteName() == 'adsUpgrade')) ? 'active' : '' }}">
         <a href="#">Payment</a>
         </li>
     </ul>
   </div>
</div>