<!-- Footer -->
<div class="navbar navbar-expand-lg navbar-light">
    <div class="text-center d-lg-none w-100">
        <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
            <i class="icon-unfold mr-2"></i>
            Footer
        </button>
    </div>

    <div class="navbar-collapse collapse" id="navbar-footer">
        <span class="navbar-text">
            &copy; {{date('Y')}}. <a href="#">{{env('APP_NAME')}}</a>
        </span>
    </div>
</div>
<!-- /footer -->

<!-- Core JS files -->
{!!Html::script('js/plugins/loaders/pace.min.js')!!}
{!!Html::script('js/main/jquery.min.js')!!}
{!!Html::script('js/main/bootstrap.bundle.min.js')!!}
{!!Html::script('js/plugins/loaders/blockui.min.js')!!}
{!!Html::script('js/plugins/ui/ripple.min.js')!!}
{!!Html::script('js/plugins/tables/datatables/datatables.min.js')!!}
{!!Html::script('js/plugins/forms/selects/select2.min.js')!!}
<!-- /core JS files -->

<!-- Theme JS files -->
{!!Html::script('js/plugins/visualization/d3/d3.min.js')!!}
{!!Html::script('js/plugins/visualization/d3/d3_tooltip.js')!!}
{!!Html::script('js/plugins/forms/styling/switchery.min.js')!!}
{!!Html::script('js/plugins/forms/selects/bootstrap_multiselect.js')!!}
{!!Html::script('js/plugins/ui/moment/moment.min.js')!!}
{!!Html::script('js/plugins/pickers/daterangepicker.js')!!}
{!!Html::script('js/theme_app.js')!!}
{!!Html::script('js/plugins/notifications/sweet_alert.min.js')!!}
{!!Html::script('js/main.js')!!}
<!-- /theme JS files -->

<script>
var modalTemplate = '<div class="modal-dialog modal-lg" role="document">\n' +
            '  <div class="modal-content">\n' +
            '    <div class="modal-header align-items-center">\n' +
            '      <h6 class="modal-title">{heading} <small><span class="kv-zoom-title"></span></small></h6>\n' +
            '      <div class="kv-zoom-actions btn-group">{toggleheader}{fullscreen}{borderless}{close}</div>\n' +
            '    </div>\n' +
            '    <div class="modal-body">\n' +
            '      <div class="floating-buttons btn-group"></div>\n' +
            '      <div class="kv-zoom-body file-zoom-content"></div>\n' + '{prev} {next}\n' +
            '    </div>\n' +
            '  </div>\n' +
            '</div>\n';

        // Buttons inside zoom modal
        var previewZoomButtonClasses = {
            toggleheader: 'btn btn-light btn-icon btn-header-toggle btn-sm',
            fullscreen: 'btn btn-light btn-icon btn-sm',
            borderless: 'btn btn-light btn-icon btn-sm',
            close: 'btn btn-light btn-icon btn-sm'
        };

        // Icons inside zoom modal classes
        var previewZoomButtonIcons = {
            prev: '<i class="icon-arrow-left32"></i>',
            next: '<i class="icon-arrow-right32"></i>',
            toggleheader: '<i class="icon-menu-open"></i>',
            fullscreen: '<i class="icon-screen-full"></i>',
            borderless: '<i class="icon-alignment-unalign"></i>',
            close: '<i class="icon-cross2 font-size-base"></i>'
        };

        // File actions
        var fileActionSettings = {
            zoomClass: '',
            zoomIcon: '<i class="icon-zoomin3"></i>',
            dragClass: 'p-2',
            dragIcon: '<i class="icon-three-bars"></i>',
            removeClass: '',
            removeErrorClass: 'text-danger',
            removeIcon: '<i class="icon-bin"></i>',
            indicatorNew: '<i class="icon-file-plus text-success"></i>',
            indicatorSuccess: '<i class="icon-checkmark3 file-icon-large text-success"></i>',
            indicatorError: '<i class="icon-cross2 text-danger"></i>',
            indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>'
        };</script>

@yield('scripts')