function confirmSwalAlert(element, description = null) {
    event.preventDefault();
	var form = element.closest('form'); // storing the form
	Swal.fire({
        title: "Are you sure?",
        text: description ?? "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        showCancelButton: true,
    })
    .then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

async function swalAlert(icon, text) {
    await Swal.fire({
        icon: icon,
        text: text,
    })
}

$(document).on("submit", '.formFilter', function(e) {
    e.preventDefault();
    const formFilter = $(this);
    var url = $(this).prop('action');
    var totalFormFilterInput = 0;
    formFilter.find('[name^="filter_"]').each(function (index) {
        if ($(this).val().trim().length) {
               if (totalFormFilterInput == 0) {
                  url += '?' + $(this).attr('name') + '=' + $(this).val();
               } else {
                  url += $(this).attr('name') + '=' + $(this).val() + "&"; 
               }                        
        }
    });
    window.location.href = url;
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('input', '[data-type="number"]', function() {
    $(this).val($(this).val().replace(/[^0-9.]/g, ''));
});

$(document).on("input", 'input[data-type="thousand"]', function() {
    $(this).val(numberWithCommas($(this).val()));
});

$(document).on('click', '.btn-copy', function() {
    copyToClipboard($(this).val())
});

function copyToClipboard(textToCopy) {
    // navigator clipboard api needs a secure context (https)
    if (navigator.clipboard && window.isSecureContext) {
        // navigator clipboard api method'
        return navigator.clipboard.writeText(textToCopy);
    } else {
        // text area method
        let textArea = document.createElement("textarea");
        textArea.value = textToCopy;
        // make the textarea out of viewport
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        textArea.style.top = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        return new Promise((res, rej) => {
            // here the magic happens
            document.execCommand('copy') ? res() : rej();
            textArea.remove();
        });
    }
}

function numberWithCommas(x) {
    if (x) {
        var parts = x.toString().split(".");
        var minus = parts[0][0] == "-" ? "-" : "";
        parts[0] = parts[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return minus + parts.join(".");
    }
    return x;
}

function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function numberNoCommas(x, d = 2) {
    if (x) {
        var parts = x.toString().split(".");
        var minus = parts[0][0] == "-" ? "-" : "";
        parts[0] = parts[0].replace(/\D/g, "");
        if (d > 0) {
            if (parts[1] == undefined) parts[1] = "00";
            else if (parts[1].length == 1) parts[1] += "0";
            else if (parts[1].length > d) parts[1] = parts[1].substring(0, d)
        }
        return minus + parts.join(".");
    }
    return x;
}

function trimTrailingZeroes(x) {
    return x.toString().indexOf(".") !== -1 ? rtrim(rtrim(x, "0"), ".") : x;
}

function numberFormatNoZeroes(x) {
    return x ? trimTrailingZeroes(number_format(x)) : x;
}
  
function rtrim (str, charlist) {
    charlist = !charlist
        ? ' \\s\u00A0'
        : (charlist + '').replace(/([[\]().?/*{}+$^:])/g, '\\$1')
    const re = new RegExp('[' + charlist + ']+$', 'g')
    return (str + '').replace(re, '')
}