<?php
$style_color1 = Helper::GeneralSiteSettings("style_color1");
$style_color2 = Helper::GeneralSiteSettings("style_color2");
$style_color3 = Helper::GeneralSiteSettings("style_color3");
$style_color4 = Helper::GeneralSiteSettings("style_color4");

?>
<style>
    a:hover, .site-top a, #topbar .contact-info i, #topbar .contact-info a:hover, #topbar .social-links a:hover, .navbar a:hover, .navbar .active, .navbar .active:focus, .navbar li:hover > a, .navbar .dropdown ul a:hover, .navbar .dropdown ul .active:hover, .navbar .dropdown ul li:hover > a, #footer .footer-bottom a, .sidebar-list .list-group .active, .sidebar-list .list-group a:hover, .contact .info i {
        color: {{ Helper::GeneralSiteSettings("style_color1") }};
    }
    .navbar .active, .navbar .active:focus {
        color: {{ Helper::GeneralSiteSettings("style_color1") }} !important;
    }
    #hero .carousel-item::before {
        background-color: {{ Helper::colorHexToRGB(Helper::GeneralSiteSettings("style_color2"),0.7) }};
    }

    a, #footer .footer-bottom a:hover, .section-title h2, .staff .member h4, .testimonials .testimonial-item h3 {
        color: {{ Helper::GeneralSiteSettings("style_color2") }};
    }

    .read-more-link:hover,.card-title:hover {
        color: {{ Helper::GeneralSiteSettings("style_color1") }} !important;
    }
    .btn-theme, #footer .footer-newsletter form button:hover, .back-to-top, .section-title h2::before, .section-title h2::after, .contact .info .email:hover i, .contact .info .address:hover i, .contact .info .phone:hover i {
        background: {{ Helper::GeneralSiteSettings("style_color1") }};
    }
    .btn-primary{
        background: {{ Helper::GeneralSiteSettings("style_color2") }};
        border-color: {{ Helper::GeneralSiteSettings("style_color2") }};
    }
    .btn-primary:hover,.btn-primary:active,.btn-primary:focus{
        background: {{ Helper::GeneralSiteSettings("style_color1") }} !important;
        border-color: {{ Helper::GeneralSiteSettings("style_color1") }} !important;
    }

    .btn-theme:hover, #footer .footer-newsletter form button, .back-to-top:hover {
        background: {{ Helper::GeneralSiteSettings("style_color2") }};
    }

    .section-bg {
        background-color: {{ Helper::GeneralSiteSettings("style_color3") }};
    }

    #footer .footer-bottom, .breadcrumbs {
        background-color: {{ Helper::GeneralSiteSettings("style_color3") }};
    }

    .testimonials .testimonial-item .quote-icon-left, .testimonials .testimonial-item .quote-icon-right {
        color: {{ Helper::GeneralSiteSettings("style_color4") }};
    }

    .testimonials .swiper-pagination .swiper-pagination-bullet {
        border-color: {{ Helper::GeneralSiteSettings("style_color1") }};
    }

    .testimonials .swiper-pagination .swiper-pagination-bullet-active {
        background-color: {{ Helper::GeneralSiteSettings("style_color1") }};
    }

    .btn-secondary, .bg-secondary {
        background-color: {{ Helper::GeneralSiteSettings("style_color1") }}   !important;
        border-color: {{ Helper::GeneralSiteSettings("style_color1") }}   !important;
    }

    .btn-secondary:hover {
        background-color: {{ Helper::GeneralSiteSettings("style_color2") }}   !important;
        border-color: {{ Helper::GeneralSiteSettings("style_color2") }}   !important;
    }

    .tooltip-inner {
        background-color: {{ Helper::GeneralSiteSettings("style_color1") }};
    }

    .bs-tooltip-auto[data-popper-placement^=top] .tooltip-arrow::before, .bs-tooltip-top .tooltip-arrow::before {
        border-top-color: {{ Helper::GeneralSiteSettings("style_color1") }};
    }
    .bs-tooltip-auto[data-popper-placement^=bottom] .tooltip-arrow::before, .bs-tooltip-top .tooltip-arrow::before {
        border-bottom-color: {{ Helper::GeneralSiteSettings("style_color1") }};
    }

    .services .icon-box:hover {
        background: {{ Helper::GeneralSiteSettings("style_color2") }}  !important;
        border-color: {{ Helper::GeneralSiteSettings("style_color2") }}  !important;
    }

    .services .icon-box {
        border-color: {{ Helper::GeneralSiteSettings("style_color1") }}   !important;
        background: {{ Helper::GeneralSiteSettings("style_color1") }}   !important;
    }

    .services .icon-box .icon i,.services .icon-box:hover .icon i{
        color: {{ Helper::GeneralSiteSettings("style_color1") }};
    }
    .bottom-article, .widget-title, .contact .info i {
        background: {{ Helper::GeneralSiteSettings("style_color3") }};
        border-color: {{ Helper::GeneralSiteSettings("style_color4") }}  !important;
    }

    .text-primary {
        color: {{ Helper::GeneralSiteSettings("style_color1") }}   !important;
    }

    .bg-primary {
        background-color: {{ Helper::GeneralSiteSettings("style_color1") }}  !important;
        border-color: {{ Helper::GeneralSiteSettings("style_color1") }}  !important;
    }

    .list-group-item, .card, .form-control, .card {
        border-color: {{ Helper::GeneralSiteSettings("style_color4") }};
    }

    .page-link {
        color: {{ Helper::GeneralSiteSettings("style_color1") }}  !important;
    }

    .active > .page-link, .page-link.active {
        background-color: {{ Helper::GeneralSiteSettings("style_color1") }}  !important;
        border-color: {{ Helper::GeneralSiteSettings("style_color1") }}  !important;
    }

    #preloader:before {
        border-color: {{ Helper::GeneralSiteSettings("style_color1") }};
        border-top-color: {{ Helper::GeneralSiteSettings("style_color4") }};
    }

    #footer .footer-top .footer-links ul a:hover, #footer a:hover, #footer a:active {
        color: {{ Helper::GeneralSiteSettings("style_color1") }};
    }

    .form-control:focus {
        border-color: {{ Helper::GeneralSiteSettings("style_color4") }};
        box-shadow: 0 0 0 0.25rem{{ Helper::GeneralSiteSettings("style_color3") }};
    }
    .dropdown-item:focus, .dropdown-item:hover{
        color: {{ Helper::GeneralSiteSettings("style_color1") }}  !important;
    }
    .select2-container--default .select2-results__option--selected {
        background-color: {{ Helper::GeneralSiteSettings("style_color3") }};
    }
    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable{
        background-color: {{ Helper::GeneralSiteSettings("style_color1") }};
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        background-color: {{ Helper::GeneralSiteSettings("style_color3") }} !important;
    }
    .bg-light {
        background-color: {{ Helper::GeneralSiteSettings("style_color2") }} !important;
    }
    .text-light {
        color: {{ Helper::GeneralSiteSettings("style_color3") }} !important;
    }
    .text-light::placeholder {
        color: {{ Helper::GeneralSiteSettings("style_color4") }} !important;
        opacity: 0.7;
    }
    .text-light::-ms-input-placeholder {
        color: {{ Helper::GeneralSiteSettings("style_color4") }} !important;
        opacity: 0.7;
    }
    .accordion-item{
        border-color: {{ Helper::GeneralSiteSettings("style_color4") }} !important;
    }

    .accordion-item:last-of-type .accordion-button.collapsed{
        background: {{ Helper::GeneralSiteSettings("style_color3") }} !important;
    }
    .accordion-button:not(.collapsed){
        color: #fff !important;
        background-color: {{ Helper::GeneralSiteSettings("style_color1") }} !important;
        box-shadow: none;
    }
    .no-data{
        color: {{ Helper::GeneralSiteSettings("style_color2") }} !important;
    }
    .btn.disabled, .btn:disabled, fieldset:disabled .btn {
        color: {{ Helper::GeneralSiteSettings("style_color4") }} !important;
    }
    .header-form-search .form-control{
        background-color: {{ Helper::GeneralSiteSettings("style_color3") }} !important;
    }
    .home-page .testimonials,.home-page .gallery{
        border-top: 1px solid {{ Helper::GeneralSiteSettings("style_color3") }} !important;
    }
    .staff .member span::after{
        background: {{ Helper::GeneralSiteSettings("style_color1") }} !important;
    }
    .cookies-accept-box{
        background-color: {{ Helper::colorHexToRGB(Helper::GeneralSiteSettings("style_color2"),0.9) }};
    }
    .post-gallery{
        background: {{ Helper::GeneralSiteSettings("style_color3") }} !important;
    }
    .line-frame{
        border: 1px solid {{ Helper::GeneralSiteSettings("style_color4") }} !important;
    }
    .gallery .gallery-item{
        border: 3px solid #fff;
    }
    .staff .member{
        background: {{ Helper::GeneralSiteSettings("style_color4") }} !important;
        box-shadow: none;
    }
    .staff .member .member-info .custom-field-value{
        background: transparent;
    }
</style>
