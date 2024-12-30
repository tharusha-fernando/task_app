<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="
                    https://cdn.jsdelivr.net/npm/sweetalert2@11.15.3/dist/sweetalert2.all.min.js
                    "></script>
    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.15.3/dist/sweetalert2.min.css
" rel="stylesheet">

    <script src="
        https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.2/dist/flasher.min.js
        "></script>
    <link href="
https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.2/dist/flasher.min.css
" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>


    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });


            showLoading = function(desc = "") {
                var backdrop = $("#loading-backdrop");
                $("#loading-backdrop .backdrop-desc").html(desc);
                backdrop.show();
                backdrop.addClass("show");
            };

            hideLoading = function() {
                var backdrop = $("#loading-backdrop");
                $("#loading-backdrop .backdrop-desc").html("");
                backdrop.removeClass("show");
                backdrop.hide();
            };


            storeData = function(
                action,
                method,
                formData,
                modal = null,
                table = null,
                redirect = null
            ) {
                $.ajax({
                    url: action,
                    type: method,
                    data: formData,
                    dataType: "json",
                    beforeSend: function() {
                        showLoading();
                    },
                    success: function(response, status, xhr) {
                        if (xhr.status === 200) {
                            if (table) {
                                flasher.success(response.message);
                                table.ajax.reload();
                            }
                            if (modal) {
                                flasher.success(response.message);
                                $(modal).modal("hide");
                            }
                            if (redirect) {
                                location.href = redirect;
                            }
                        } else if (xhr.status === 204) {
                            flasher.warning("Please make any changes.");
                        } else if (xhr.status === 205) {
                            flasher.error(response.message);
                        } else {
                            flasher.error("Internal server error.");
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            displayValidationErrors(errors);
                        } else {
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                flasher.error(xhr.responseJSON.error);
                            } else {
                                flasher.error("Internal server error.");
                            }
                        }
                    },
                    complete: function() {
                        hideLoading();
                    },
                });
            };

            displayValidationErrors = function(errors) {
                $.each(errors, function(key, value) {
                    var error = "";
                    $.each(value, function(index, errorMessage) {
                        error = error + errorMessage + " <br>";
                    });
                    var keyForClass = key.replace(/\./g, "_");
                    $(".error_" + keyForClass)
                        .html(error)
                        .closest(".form-group")
                        .addClass("border--red");
                });
            };
            changeStatus = function(url, table = null, id, callback = null) {
                Swal.fire({
                    title: "Are You Sure??",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                id: id
                            },
                            beforeSend: function() {
                                showLoading();
                            },
                            success: function(response, status, xhr) {
                                if (xhr.status === 200) {
                                    flasher.success(response.message);
                                    if (table) {
                                        table.ajax
                                            .reload(); // Reload the table if it's provided
                                    }
                                } else {
                                    flasher.error("Internal server error.");
                                }
                                // Call the callback function if provided
                                if (callback) {
                                    callback(); // Call the callback after the success
                                }
                            },
                            error: function(xhr) {
                                if (xhr.status === 406) {
                                    flasher.warning(xhr.responseJSON.error);
                                    if (table) {
                                        table.ajax.reload();
                                    }
                                } else {
                                    flasher.error("Internal Server Error.");
                                }
                            },
                            complete: function() {
                                hideLoading();
                            },
                        });
                    }
                });
            };

            changeActiveStatus = function(url, table = null) {
                Swal.fire({
                    title: "Are You Sure??", //Do you want to delete this User?//r
                    showCancelButton: true,
                    confirmButtonText: "Yes", //Delete
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "GET",
                            beforeSend: function() {
                                showLoading();
                            },
                            success: function(response, status, xhr) {
                                if (xhr.status === 200) {
                                    flasher.success(response.message);
                                    if (table) {
                                        table.ajax.reload();
                                    }
                                } else if (xhr.status === 203) {
                                    flasher.warning(
                                        "You cannot change logged user details.");
                                } else {
                                    flasher.error("Internal server error.");
                                }
                            },
                            error: function(xhr) {
                                if (xhr.responseJSON && xhr.responseJSON.error) {
                                    flasher.error(xhr.responseJSON.error);
                                } else {
                                    flasher.error("Internal Server Error.");
                                }
                            },
                            complete: function() {
                                hideLoading();
                            },
                        });
                    }
                });
            };

            destroyData = function(url, table = null, shouldRefresh = false) {
                // Use Swal to confirm deletion
                Swal.fire({
                    title: 'Do you want to delete this item?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    icon: 'warning',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Perform the AJAX request
                        $.ajax({
                            url: url,
                            type: "DELETE",
                            beforeSend: function() {
                                showLoading();
                            },
                            success: function(response, status, xhr) {
                                if (xhr.status === 200) {
                                    flasher.success(response.message);
                                    if (table) {
                                        table.ajax.reload();
                                    }
                                    if (shouldRefresh) {
                                        location.reload();
                                    }
                                } else if (xhr.status === 203) {
                                    flasher.warning(
                                        "You cannot change logged user details.");
                                } else {
                                    flasher.error("Internal server error.");
                                }
                            },
                            error: function(xhr) {
                                if (xhr.responseJSON && xhr.responseJSON.error) {
                                    flasher.error(xhr.responseJSON.error);
                                } else {
                                    flasher.error("Internal server error.");
                                }
                            },
                            complete: function() {
                                hideLoading();
                            },
                        });
                    }
                });
            };


            exportFile = function(url) {
                window.open(url, "_blank");
            };

        });
    </script>
</body>

</html>
