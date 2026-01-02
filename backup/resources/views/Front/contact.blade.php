@extends('layouts.front')
@section('content')

<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                       <h1>Contact</h1>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>Contact</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->
                                      


    <!--contact area start-->
    <div class="contact_area">
        <div class="container">   
            <div class="row">
                <div class="col-lg-6 col-md-6">
                   <div class="contact_message content">
                        <h3>contact us</h3>    
                        
                        <ul>
                            <li><i class="fa fa-map-marker"></i>  F-80, F-81, Tulsi Industrial Estate , Opp Bhagyoday Hotel, Changodhar, Gujarat 362213</li>
                            <li><i class="fa fa-envelope"></i> <a href="#">Info@tonguetwister.com</a></li>
                            <li><i class="fa fa-phone"></i><a href="tel:+91 8780418312">+91 8780418312</a>  </li>
                        </ul>             
                    </div> 
                </div>
                <div class="col-lg-6 col-md-6">
                   <div class="contact_message form">
                        <h3>Tell us your project</h3> 
                        <form action="{{ route('contact_us') }}" method="post">
                            @csrf  
                            <p>  
                               <label> Your Name <span style="color:red;">*</span></label>
                                <input type="text" name="name" placeholder="Enter Your Name"  value="{{ old('name') }}" required>
                                @error('name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror                                

                            </p>
                            <p>       
                               <label>  Your Email <span style="color:red;">*</span></label>
                                <input type="email" name="email" placeholder="Enter Your Email"  value="{{ old('email') }}" required>
                                    @error('email')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror                           
                            </p>
                            <p>          
                               <label>Your Mobile <span style="color:red;">*</span></label>
                                <input type="text" name="mobile" maxlength="10" minlength="10"
                                    onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                    value="{{ old('mobile') }}" placeholder="Enter Your Mobile Number"
                                    required>
                                @error('mobile')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </p>    
                            <div class="contact_textarea">
                                <label>  Your Message</label>
                                <textarea class="w-100" name="message" id="" cols="30" placeholder="Enter Your Message" rows="4">{{ old('message') }}</textarea>                            
                            </div>   
                                    <!--<label for="captcha">Please enter the CAPTCHA:</label>
                                    <span>{!! captcha_img() !!}</span>
				                           <button type="button" class="btn btn-danger" class="reload" id="reload" name="captcha">
				                                &#x21bb;
				                            </button>
									
									 

                                            <input type="text" name="captcha" required placeholder="Enter CAPTCHA"><br>
                                            <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                                                @error('captcha')
        				                        <span class="text-danger">
        				                            <strong id="captchaError">{{ $message }}</strong>
        				                        </span>
        				                      @enderror-->
                                        </div>
                            <button type="submit"> Send</button>  
                        </form> 
                        @include('common.frontalert')
                    </div> 
                </div>
            </div>
        </div>    
    </div>

    <!--contact area end-->

    
    <!--contact map start-->
    <div class="contact_map mt-70">
        <div class="map-area">
            <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d38646.703815829074!2d72.43220442032441!3d22.925100585554212!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e90dae6bff375%3A0x2fd6f2f2dbe62c70!2sChangodar%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1727935210971!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>-->
       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3674.4414973292864!2d72.45057837508898!3d22.933962079236032!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e90eb2bbaa987%3A0x987890d420e98d3a!2sTulsi%20Estate!5e0!3m2!1sen!2sin!4v1729588860121!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
     </div>
     <!--contact map end-->
@endsection
@section('scripts')

    <script type="text/javascript">
            function refreshCaptcha() {
        document.querySelector('.captcha-img').src = "{{ captcha_src() }}" + "?" + Math.random();
    }
    </script>

    <script>
      
    </script>
@endsection
