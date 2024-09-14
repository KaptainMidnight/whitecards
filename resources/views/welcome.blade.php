@extends('layouts.app')

@section('content')
    <section id="loadSection" class="load section section-load">
        <div class="load__logotype logotype">
            <img src="../sources/logo.svg" alt="Whitecards Logo"/>
        </div>
        <div class="load__progress">
            <div id="progress"></div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('loadData', () => ({
                widthLoad: 0,
                
                async init() {
                    this.hideBackButton();
                    await this.animateProgressBar();
                    this.redirectToProfile();
                },
                
                hideBackButton() {
                    window.Telegram.WebApp.BackButton.hide();
                },
                
                async animateProgressBar() {
                    for (let i = 0; i < 501; i++) {
                        this.widthLoad = i / 5;
                        await this.delay(1);
                        this.updateProgressBar();
                    }
                },
                
                delay(ms) {
                    return new Promise(resolve => setTimeout(resolve, ms));
                },
                
                redirectToProfile() {
                    window.location.replace('/profile');
                },
                
                updateProgressBar() {
                    const progressBar = document.getElementById('progress');
                    if (progressBar) {
                        progressBar.style.width = `${this.widthLoad}%`;
                    }
                }
            }));
        });

        document.addEventListener('DOMContentLoaded', () => {
            const loadSection = document.getElementById('loadSection');
            if (loadSection) {
                loadSection.setAttribute('x-data', 'loadData');
                Alpine.initializeComponent(loadSection);
            }
        });
    </script>
@endpush
