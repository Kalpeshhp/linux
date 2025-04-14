@extends('layouts.site')
@section('content')
    <!-- Main Section Start -->
        <!-- Banner section -->
        <section class="home-banner">
            <div class="slider page-container">
                @if(Session::has('message'))
                <div role="alert" class="alert alert-success">
                {{ Session::get('message') }}
                @php
                Session::pull('message');
                @endphp
                </div>
                @endif
                <div class="slider-content text-center">
                    <h1 class="slider-title">Create your Online Tailor Store</h1>
                    <a href="" class="purple-btn">Get Started</a>
                </div>
                <img src="images/tailori-images/banner_img.png">
            </div>
        </section>
        <!-- Custom Tailoring Webstore -->
        <section class="ct-webstore page-container sec-pad">
            <div class="ct-webstore-img">
                <figure>
                    <img src="images/tailori-images/web-store-1.png" alt="Custom Tailoring Webstore">
                </figure>
                <figure>
                    <img src="images/tailori-images/web-store-2.png" alt="Custom Tailoring Webstore">
                </figure>
            </div>
            <div class="ct-webstore-content">
                <h2 class="sec-title">Custom Tailoring Webstore</h2>
                <p>Bespoke Tailoring has never been this simple. Join us and instantly create your own personalised tailoring shop in no time with our revolutionary Design Configurator and a wide variety of fabrics to choose from.</p>
                <a href="" class="purple-btn">CLICK HERE FOR DEMO</a>
            </div>
        </section>
        <!-- Build Your Unique Online Tailor Store -->
        <section class="build-store-sec ">
            <div class="build-store-content sec-pad">
                <h2 class="sec-title">Build Your Unique Online Tailor Store</h2>
                <div class="build-store-pts">
                    <div>
                        <h3 class="sub-title"><span>1</span> Bulid</h3>
                        <p>Instantly get connected with us and start you own bespoke tailoring store in no time.</p>
                    </div>
                    <div>
                        <h3 class="sub-title"><span>2</span> Control</h3>
                        <p>Our revolutionary Design Configurator and the backend panel for customers is very polished and simplified to use.</p>
                    </div>
                    <div>
                        <h3 class="sub-title"><span>3</span> Manage</h3>
                        <p>Easily add and remove products from your online inventory and also get access to user analytics</p>
                    </div>
                    <div>
                        <h3 class="sub-title"><span>4</span> Grow</h3>
                        <p>With an endless reach and consumer prospects, Shopping on the go for a custom tailored garment is now a reality</p>
                    </div>
                    
                </div>
            </div>
            <div class="build-store-slider sec-pad">
                <div class="slide">
                    <img src="images/tailori-images/tailor-store-slider-1.png" alt="Build Your Unique Online Tailor Store">
                </div>
            </div>
        </section>
        <!-- how it works -->
        <section class="sec-pad page-container how-it-works-sec">
            <h2 class="sec-title text-center">How it Works</h2>
            <div class="how-it-works-pt-list">
                <div class="how-it-works-pt">
                    <div><img src="images/tailori-images/step-1.png" alt="Create an Account"></div>
                    <div>
                        <h3 class="sub-title">1. Create an Account</h3>
                        <p>Sign up for custom tailors store and get your account activated instantly</p>
                    </div>
                </div>
                <div class="how-it-works-pt">
                    <div><img src="images/tailori-images/step-2.png" alt="Choose your Plan"></div>
                    <div>
                        <h3 class="sub-title">2. Choose your Plan</h3>
                        <p>To choose a plan, navigate to the plans tab  and select from a wide variety of plans</p>
                    </div>
                </div>
                <div class="how-it-works-pt">
                    <div><img src="images/tailori-images/step-3.png" alt="Select the Template"></div>
                    <div>
                        <h3 class="sub-title">3. Select the Template</h3>
                        <p>Select the template that you would like to use to create your online tailor store.</p>
                    </div>
                </div>
                <div class="how-it-works-pt">
                    <div><img src="images/tailori-images/step-4.png" alt="Finalise your Template"></div>
                    <div>
                        <h3 class="sub-title">4. Finalise your Template</h3>
                        <p>With added facility to upload your own store branding / banners to personalise your store</p>
                    </div>
                </div>
                <div class="how-it-works-pt">
                    <div><img src="images/tailori-images/step-5.png" alt="Upload Fabrics"></div>
                    <div>
                        <h3 class="sub-title">5. Upload Fabrics</h3>
                        <p>The customer can pick their fabric library  ”or have their own fabrics digitized.</p>
                    </div>
                </div>
                <div class="how-it-works-pt">
                    <div><img src="images/tailori-images/step-6.png" alt="Ready to Use"></div>
                    <div>
                        <h3 class="sub-title">6. Ready to Use</h3>
                        <p>And your fully working custom online store is ready to use</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Features -->
        <section class="sec-pad page-container features-sec">
            <h2 class="sec-title text-center">Features</h2>
            <div class="features-list">
                <div class="features-pt">
                    <div>
                        <img src="images/tailori-images/payment.png" alt="Trusted Payment Getaway">
                    </div>
                    <div>
                        <h3>Trusted Payment Getaway</h3>
                        <p>Our trusted payment gateway providers such as CC avenue, Citrus Pay , etc to ensure a secure payment management process.</p>
                    </div>
                </div>
                <div class="features-pt">
                    <div>
                        <img src="images/tailori-images/cdnintegration.png" alt="CDN Integration Enabled">
                    </div>
                    <div>
                        <h3>CDN Integration Enabled</h3>
                        <p>CDN services ensure a lag-free and smooth experience for our customers from across the globe.</p>
                    </div>
                </div>
                <div class="features-pt">
                    <div>
                        <img src="images/tailori-images/support.png" alt="Powerfull Customer Support">
                    </div>
                    <div>
                        <h3>Powerfull Customer Support</h3>
                        <p>Our priority is to ensure a seamless and uninterrupted experience. Also, our customer service representatives are available to assist if need be.</p>
                    </div>
                </div>
                <div class="features-pt">
                    <div>
                        <img src="images/tailori-images/responsive.png" alt="Responsive Templates">
                    </div>
                    <div>
                        <h3>Responsive Templates</h3>
                        <p>We provide a wide variety of responsive templates which are very customer centric to enhance the experience of our customers</p>
                    </div>
                </div>
                <div class="features-pt">
                    <div>
                        <img src="images/tailori-images/customise.png" alt="Secure & Powerful Admin Panel">
                    </div>
                    <div>
                        <h3>Secure & Powerful Admin Panel</h3>
                        <p>Secure Admin Panel to add / remove the fabrics and also to keep a track of the orders and billing with insights on your site traffic and how visitors behave.</p>
                    </div>
                </div>
                <div class="features-pt">
                    <div>
                        <img src="images/tailori-images/fabric.png" alt="Fabric Digitization Facility">
                    </div>
                    <div>
                        <h3>Fabric Digitization Facility</h3>
                        <p>We also provide the facility to digitize our customer’s fabrics so that they can have their own material in the fabric library.</p>
                    </div>
                </div>
            </div>
        </section>
    <!-- Main Section End -->
@endsection