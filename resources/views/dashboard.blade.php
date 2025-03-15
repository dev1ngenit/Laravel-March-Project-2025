<x-app-layout>
    <style>
        .slick-dots {
            left: auto;
            position: absolute;
            bottom: -30px;
            display: flex;
            justify-content: center;
            /* Ensures dots are centered */
            gap: 5px;
            /* Adds consistent space between dots */
        }
    </style>


    <div class="mobile-homepage w-100 bg-white" style="padding-bottom: 9rem">
        <div class="p-0">
            <div class="container-fluid pt-5 "
                style="background: linear-gradient(180deg, #F15A2D 10%, rgb(255 255 255 / 0%) 100%);width: 100%;height: 296px; padding-top: 80px;">
                <div class="row align-items-centers px-5 pt-10">
                    <div class="col-8">
                        <div class="user-info">
                            <img src="{{ asset('admin/assets/media/avatars/300-1.jpg') }}" alt="">
                            <div class="ps-2">
                                <h2 class="text-white">{{ Auth::user()->name }}</h2>
                                <div class="d-flex align-items-centers">
                                    <span class="text-white">{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">

                        <div class="d-flex justify-content-end align-items-center pt-5 text-end">
                            <div class="">
                                <a href="javascript:void(0)" class="" data-bs-toggle="modal"
                                    data-bs-target="#user-search">
                                    <span style="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25"
                                            viewBox="0 0 24 25" fill="none">
                                            <path
                                                d="M23.3561 22.9272L17.4839 17.0551C19.0841 15.098 19.8709 12.6006 19.6815 10.0797C19.4921 7.55875 18.341 5.20704 16.4662 3.511C14.5915 1.81497 12.1366 0.90437 9.60928 0.967559C7.08198 1.03075 4.67564 2.06289 2.88801 3.8505C1.10038 5.6381 0.0682254 8.0444 0.00503493 10.5717C-0.0581555 13.0989 0.852456 15.5538 2.54852 17.4285C4.24458 19.3032 6.59632 20.4543 9.11731 20.6437C11.6383 20.8331 14.1356 20.0464 16.0928 18.4461L21.965 24.3183C22.1506 24.4975 22.3991 24.5966 22.657 24.5944C22.915 24.5922 23.1617 24.4887 23.3441 24.3063C23.5265 24.1239 23.63 23.8771 23.6322 23.6192C23.6345 23.3613 23.5353 23.1128 23.3561 22.9272ZM9.87132 18.7039C8.31472 18.7039 6.79308 18.2423 5.49881 17.3775C4.20455 16.5127 3.19579 15.2836 2.60011 13.8455C2.00442 12.4074 1.84857 10.825 2.15224 9.2983C2.45592 7.77163 3.20549 6.3693 4.30618 5.26864C5.40686 4.16797 6.80921 3.41841 8.3359 3.11474C9.86259 2.81106 11.445 2.96692 12.8832 3.56259C14.3213 4.15827 15.5504 5.16701 16.4152 6.46126C17.28 7.7555 17.7416 9.27712 17.7416 10.8337C17.7393 12.9203 16.9093 14.9207 15.4339 16.3962C13.9584 17.8716 11.9579 18.7015 9.87132 18.7039Z"
                                                fill="white" />
                                        </svg>
                                    </span>
                                </a>
                            </div>

                            <div class="dropdown position-static ps-3">
                                <!-- Add a form to send a POST request for logout -->
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf <!-- Laravel CSRF protection -->
                                    <button type="submit" class="btn btn-link p-0 m-0">Logout</button>
                                </form>
                            </div>


                        </div>
                    </div>

                </div>

                <div class="row pt-5 mt-5">



                </div>



            </div>
        </div>





    </div>


</x-app-layout>
