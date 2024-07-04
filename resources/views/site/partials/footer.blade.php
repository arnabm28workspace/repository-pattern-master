<footer class="py-4">
<div class="container pt-4">
<div class="row">
   <!-- <div class="col-12 col-lg-5">
       <h4>Locations</h4>
       <ul> 
           <li><a href="">Browse in your location</a></li>
           <li><a href="">London North</a></li>
           <li><a href="">East North</a></li> 
           <li><a href="">West Wales</a></li> 
           <li><a href="">West Midlands</a></li> 
           <li><a href="">Europe</a></li>
       </ul>
   </div> -->
    <div class="col-12 col-lg-10">
        <h4>Popular Searches</h4>
        <ul>
            <li>Our Popular Links</li>
            
              @php 
                $i=0;
              @endphp 
              @foreach ($mostSearchedContent as $search_content) 
                @php
                  $search_content_data = $search_content['search_content'];
                  $search_category = $search_content_data['category'];
                  $search_country = $search_content_data['country'];
                  $search_city = $search_content_data['city'];
                @endphp
                @if((!empty($search_category) || !empty($search_country) || !empty($search_city)) && $i<5)

                  @php 
                    $i++;  
                    $display_category = (!empty($search_category))?ucwords(str_replace('-', ' ', $search_category)):"";
                    $display_country = (!empty($search_country))?ucwords(str_replace('-', ' ', $search_country)):"";
                    $display_city = (!empty($search_city))?ucwords(str_replace('-', ' ', $search_city)):"";
                    $display_text="";
                  @endphp
                  @if(!empty($display_category) && !empty($display_country) && !empty($display_city))
                    @php  
                      $display_text=$display_category." ".$display_country." ".$display_city;
                    @endphp
                  @endif
                
                <li><a href="javascript:void(0);" class="searchlink" data-formid="mostsearchform{{$i}}">{{$display_text}}</a></li>
                <form action="{{ route('process-search') }}" method="post" id="mostsearchform{{$i}}">
                  @csrf
                  <input type="hidden" name="category" value="{{$search_category}}">
                  <input type="hidden" name="country" value="{{$search_country}}">
                  <input type="hidden" name="city" value="{{$search_city}}">
                </form>
              
                @endif
              @endforeach
        </ul>
    </div>
    <div class="col-12 col-lg-2">
        <h4 class="pb-3">Follow Us</h4>
        <div class="row pl-3">
            <div class="flex-column px-2"><a href="{{\App\Models\Setting::get('social_twitter')}}" class="text-dark"><i class="fab fa-twitter"></i></a></div>
            <div class="flex-column px-2"><a href="{{\App\Models\Setting::get('social_facebook')}}" class="text-dark"><i class="fab fa-facebook-f"></i></a></div>
            <div class="flex-column px-2"><a href="{{\App\Models\Setting::get('social_instagram')}}" class="text-dark"><i class="fab fa-instagram"></i></a></div>
        </div>
    </div>
</div>
</div>
</footer>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).on('click','.searchlink',function()
  {
    var form_id = $(this).data("formid");
    console.log(form_id);
    $("#"+form_id).submit();
  })
</script>