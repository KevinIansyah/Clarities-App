@extends('layouts.main')

@section('title')
  @if (request()->has('tag'))
    {{ request('tag') }} - Clarities
  @elseif(request()->has('search'))
    {{ request('search') }} - Clarities
  @else
    Blog Search - Clarities
  @endif
@endsection

@section('meta-description')
  @if (request()->has('tag'))
    Temukan artikel dengan tag "{{ request('tag') }}" di Clarities Laboratorium Hukum UPN Veteran Jatim.
  @elseif(request()->has('search'))
    Hasil pencarian untuk "{{ request('search') }}" di blog Clarities Laboratorium Hukum UPN Veteran Jatim.
  @else
    Temukan artikel dan berita terbaru di blog Clarities Laboratorium Hukum UPN Veteran Jatim.
  @endif
@endsection

@section('main')
  <div class="container" style="margin-top: 8rem; margin-bottom: 5rem;">
    <div class="row">
      <div class="col-xl-12">
        <nav class="d-flex justify-content-center w-100" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-dots mb-1">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Hasil Pencarian</li>
          </ol>
        </nav>

        <h2 class="mb-2 font-weight-bold text-center">Hasil Pencarian</h2>
        <div class="blog-search mb-5 d-flex justify-content-center w-100">
          <form role="search" method="GET" action="{{ route('blog.search') }}">
            <input class="form-control me-2" type="search" name="search" placeholder="Cari blog..." aria-label="Search">
          </form>
        </div>

        @if ($blogs->isEmpty())
          <p class="mb-0 text-gray-500 fst-italic text-center">
            @if (request()->has('tag') || request()->has('search'))
              Data tidak ditemukan untuk '{{ request()->get('tag') ?? request()->get('search') }}'.
            @else
              Belum ada data untuk ditampilkan!
            @endif
          </p>
        @else
          <div class="row g-5 mb-5">
            @foreach ($blogs as $item)
              <div class="col-md-6 col-lg-4">
                <a href="{{ route('blog.show', $item->slug) }}"
                  class="d-flex flex-column gap-2 rounded text-decoration-none"
                  style="cursor: pointer; position: relative;">
                  <img src="{{ asset('storage/filepond-image/' . $item->image) }}"
                    class="w-100 object-fit-cover object-position-center rounded" style="height: 12rem"
                    alt="foto blog {{ $item->title }}">
                  <div class="px-2 mt-2">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                      <span class="badge btn-inverse-secondary mb-2">
                        {{ $item->created_at->diffForHumans() }}</span>
                      <span class="badge btn-inverse-secondary mb-2">
                        {{ $item->view }} dilihat</span>
                      <span class="badge btn-inverse-secondary mb-2">
                        {{ $item->read }} menit baca</span>
                    </div>
                    <p class="blog-title font-weight-semibold text-black">{{ $item->title }}</p>
                    <p class="blog-overview text-gray-600">{{ $item->overview }}</p>
                    <div class="d-flex align-items-center justify-content-end">
                      <div class="badge btn-inverse-danger d-flex align-items-center gap-2">
                        <p class="mb-0" style="font-size: 0.9rem">Read More</p>
                        <i class="fa-light fa-arrow-right"></i>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>

          <div class="row mt-7">
            <div class="col-12 mx-auto">
              <ul class="pagination d-flex justify-content-center mb-0 d-sm-none">
                <!-- Tautan Halaman Sebelumnya -->
                @if ($blogs->onFirstPage())
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Prev</a>
                  </li>
                @else
                  <li class="page-item">
                    <a class="page-link" href="{{ $blogs->previousPageUrl() }}">Prev</a>
                  </li>
                @endif

                <!-- Elemen Pagination -->
                @if ($blogs->lastPage() == 1)
                  <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                  </li>
                @elseif ($blogs->lastPage() == 2)
                  <li class="page-item">
                    <a class="page-link" href="{{ $blogs->url(1) }}">1</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="{{ $blogs->url(2) }}">2</a>
                  </li>
                @else
                  @if ($blogs->currentPage() == 1)
                    <li class="page-item active">
                      <a class="page-link" href="{{ $blogs->url(1) }}">1</a>
                    </li>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    <li class="page-item">
                      <a class="page-link" href="{{ $blogs->url($blogs->lastPage()) }}">{{ $blogs->lastPage() }}</a>
                    </li>
                  @elseif ($blogs->currentPage() == $blogs->lastPage())
                    <li class="page-item">
                      <a class="page-link" href="{{ $blogs->url(1) }}">1</a>
                    </li>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    <li class="page-item active">
                      <a class="page-link" href="#">{{ $blogs->currentPage() }}</a>
                    </li>
                  @else
                    <li class="page-item active">
                      <a class="page-link" href="#">{{ $blogs->currentPage() }}</a>
                    </li>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    <li class="page-item">
                      <a class="page-link" href="{{ $blogs->url($blogs->lastPage()) }}">{{ $blogs->lastPage() }}</a>
                    </li>
                  @endif
                @endif

                <!-- Tautan Halaman Berikutnya -->
                @if ($blogs->hasMorePages())
                  <li class="page-item">
                    <a class="page-link" href="{{ $blogs->nextPageUrl() }}">Next</a>
                  </li>
                @else
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Next</a>
                  </li>
                @endif
              </ul>
              <ul class="pagination pagination-lg d-flex justify-content-center mb-0 d-none d-sm-flex">
                <!-- Tautan Halaman Sebelumnya -->
                @if ($blogs->onFirstPage())
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Prev</a>
                  </li>
                @else
                  <li class="page-item">
                    <a class="page-link" href="{{ $blogs->previousPageUrl() }}">Prev</a>
                  </li>
                @endif

                <!-- Elemen Pagination -->
                @if ($blogs->lastPage() == 1)
                  <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                  </li>
                @elseif ($blogs->lastPage() == 2)
                  <li class="page-item">
                    <a class="page-link" href="{{ $blogs->url(1) }}">1</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="{{ $blogs->url(2) }}">2</a>
                  </li>
                @else
                  @if ($blogs->currentPage() == 1)
                    <li class="page-item active">
                      <a class="page-link" href="{{ $blogs->url(1) }}">1</a>
                    </li>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    <li class="page-item">
                      <a class="page-link" href="{{ $blogs->url($blogs->lastPage()) }}">{{ $blogs->lastPage() }}</a>
                    </li>
                  @elseif ($blogs->currentPage() == $blogs->lastPage())
                    <li class="page-item">
                      <a class="page-link" href="{{ $blogs->url(1) }}">1</a>
                    </li>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    <li class="page-item active">
                      <a class="page-link" href="#">{{ $blogs->currentPage() }}</a>
                    </li>
                  @else
                    <li class="page-item active">
                      <a class="page-link" href="#">{{ $blogs->currentPage() }}</a>
                    </li>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    <li class="page-item">
                      <a class="page-link" href="{{ $blogs->url($blogs->lastPage()) }}">{{ $blogs->lastPage() }}</a>
                    </li>
                  @endif
                @endif

                <!-- Tautan Halaman Berikutnya -->
                @if ($blogs->hasMorePages())
                  <li class="page-item">
                    <a class="page-link" href="{{ $blogs->nextPageUrl() }}">Next</a>
                  </li>
                @else
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Next</a>
                  </li>
                @endif
              </ul>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
