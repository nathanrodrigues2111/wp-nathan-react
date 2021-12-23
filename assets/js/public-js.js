const getParentCommentCount = () => {
    const currentParentTarget = document.querySelectorAll('.depth-1.parent');
    let commentCount = 0;
    if (currentParentTarget) {
        currentParentTarget.forEach(single => {
            currentAllCount = single.querySelectorAll('.last');
            currentAllCount.forEach(element => {
                let addingCount = parseInt(element.querySelector('.wpnat-count').textContent);
                commentCount  = commentCount + addingCount; 
            });
            single.querySelector('.wpnat-comments-count').textContent = commentCount;
            commentCount = 0;
        });
    }
}

document.addEventListener(
    "DOMContentLoaded",
    function () {
        const hideChildrenComments = document.querySelectorAll('.wpnat-comment-body > .wpnat-comment-arrow-trigger');
        const checkParentCount = document.querySelectorAll('.wpnat-comments-count');

        if (hideChildrenComments) {
            hideChildrenComments.forEach(element => {
                element.addEventListener('click', (e) => {
                    e.currentTarget.parentElement.parentElement.classList.toggle('hide')
                });
            });
        }

        if(checkParentCount) {
            getParentCommentCount();
        }
    }
);
