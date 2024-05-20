function getString(data) {
    const myJSONString = JSON.stringify(data);
    let regexString = "";
    // for tracking matches, in particular the curly braces
    const brace = {
        brace: 1
    };
    $("#myJSONString").html(myJSONString);
    regexString = myJSONString.replace(
        /({|}[,]*|[^{}:]+:[^{}:,]*[,{]*)/g,
        function(m, p1) {
            const returnFunction = function() {
                return `<div style="text-indent: ${brace["brace"] * 20}px;">${p1.replace(/\\/g, '')}</div>`;
            };
            let returnString = 0;
            if (p1.lastIndexOf("{") === p1.length - 1) {
                returnString = returnFunction();
                brace["brace"] += 1;
            } else if (p1.indexOf("}") === 0) {
                brace["brace"] -= 1;
                returnString = returnFunction();
            } else {
                returnString = returnFunction();
            }
            return returnString;
        }
    );
    return regexString;
}


// when ready
$(function(){

    $('body').on('click' , '.dropdown-c > .dropdown-c-toggle' , function(){
        var tag = $(this);
        tag.attr('aria-expanded' , 'true');
        tag.toggleClass('show');
        $('.dropdown-c .dropdown-menu').removeClass('show');

        if(tag.hasClass('show')){
            tag.parent().find('.dropdown-menu').addClass('show');
        }else{
            tag.parent().find('.dropdown-menu').removeClass('show');
        }

        console.log('done');
    });
    // $('body').on('click', '.dropdown-c-toggle', function() {
    //     // Toggle the dropdown for the specific clicked button
    //     $(this).siblings('.dropdown-menu').toggleClass('show');
    //   });

    //   // Hide dropdowns when clicking outside of them
    //   $(document).on('click', function(event) {
    //     if (!$(event.target).closest('.dropdown').length) {
    //       $('.dropdown-menu').removeClass('show');
    //     }
    //   });
});
