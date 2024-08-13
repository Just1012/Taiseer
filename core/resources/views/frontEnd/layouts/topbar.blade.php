<div id="topbar"
     class="d-flex align-items-center {{ (Helper::GeneralSiteSettings("style_header"))?"fixed-top":"" }} {{ (Helper::GeneralSiteSettings("style_bg_type"))?"topbar-no-bg":"header-bg" }}">
    <div class="container d-flex justify-content-between">
        <div class="contact-info d-flex align-items-center">
            @if(Helper::GeneralSiteSettings("contact_t3") !="")
                <i class="fa fa-phone"></i> &nbsp;<a
                    href="tel:{{ Helper::GeneralSiteSettings("contact_t5") }}"><span
                        dir="ltr">{{ Helper::GeneralSiteSettings("contact_t5") }}</span></a>
            @endif
            @if(Helper::GeneralSiteSettings("contact_t6") !="")
                <span class="top-email d-none d-lg-block ">
                    @if(Helper::GeneralSiteSettings("contact_t3") !="")
                        &nbsp; | &nbsp;
                    @endif
                    <i class="fa fa-envelope"></i> &nbsp;<a
                        href="mailto:{{ Helper::GeneralSiteSettings("contact_t6") }}">{{ Helper::GeneralSiteSettings("contact_t6") }}</a>
                    </span>
            @endif
        </div>
        <div class="d-flex align-items-center">
            @if(Helper::GeneralWebmasterSettings("header_search_status"))
            {{Form::open(['url'=>Helper::sectionURL(1),'method'=>'GET','class'=>'header-form-search'])}}
            <div>
                {!! Form::text('search_word',@$search_word, array('placeholder' => __('backend.search'),'class' => 'form-control form-control-sm mb-0','id'=>'search_word','required'=>'','maxlength'=>50,'autocomplete'=>'off')) !!}
                <button class="btn btn-sm" type="submit" id="button-addon2"><i class="fa fa-search"></i>
                </button>
            </div>
            {{Form::close()}}
            @endif

            @if(Helper::GeneralWebmasterSettings("dashboard_link_status"))
                @if(Auth::check())
                    <div class="dropdown header-dropdown d-none d-sm-block">
                        <button class="btn dropdown-toggle" type="button" id="dropdownDashboardBtn"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user"></i> {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownDashboardBtn">
                            <li><a class="dropdown-item" href="{{ route("adminHome") }}"><i
                                        class="fa fa-cog"></i> {{__('frontend.dashboard')}}</a></li>
                            @if(Auth::user()->permissions ==0 || Auth::user()->permissions ==1)
                                <a class="dropdown-item"
                                   href="{{ route('usersEdit',Auth::user()->id) }}"> <i
                                        class="fa fa-user"></i> {{ __('backend.profile') }}</a>
                            @endif
                            @if(Helper::GeneralWebmasterSettings("inbox_status"))
                                @if(@Auth::user()->permissionsGroup->inbox_status)
                                    <a href="{{ route('webmails') }}" class="dropdown-item">
                                        <i class="fa fa-envelope"></i> {{ __('backend.siteInbox') }}
                                    </a>
                                @endif
                            @endif
                            <a class="dropdown-item" href="{{ route('adminLogout') }}"><i
                                    class="fa fa-sign-out"></i> {{ __('backend.logout') }}</a>
                        </ul>
                    </div>
                @else
                    <strong class="d-none d-sm-block">
                        <a href="{{ route("adminHome") }}" target="_blank"><i
                                class="fa fa-cog"></i> {{__('frontend.dashboard')}}
                        </a>
                    </strong>
                @endif
            @endif
            @if(count(Helper::languagesList()) >1)
                <div class="dropdown header-dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownLangBtn"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        @if(@Helper::currentLanguage()->icon !="")
                            <img
                                src="{{ asset('assets/dashboard/images/flags/'.@Helper::currentLanguage()->icon.".svg") }}"
                                alt="{{ @Helper::currentLanguage()->title }}" loading="lazy">
                        @endif
                        {{ @Helper::currentLanguage()->title }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownLangBtn">
                        @foreach(Helper::languagesList() as $ActiveLanguage)
                            <a href="{{ Helper::languageURL($ActiveLanguage->code, @$page_type , @$page_id) }}"
                               class="dropdown-item">
                                @if($ActiveLanguage->icon !="")
                                    <img
                                        src="{{ asset('assets/dashboard/images/flags/'.$ActiveLanguage->icon.".svg") }}"
                                        alt=" {{ $ActiveLanguage->title }}" loading="lazy">
                                @endif
                                {{ $ActiveLanguage->title }}
                            </a>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(!Helper::GeneralWebmasterSettings("dashboard_link_status") && count(Helper::languagesList()) ==1)
                @include("frontEnd.layouts.social",["tt_position"=>"bottom"])
            @endif
        </div>
    </div>
</div>
