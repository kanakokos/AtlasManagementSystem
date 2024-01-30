$(function () {
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
  });

  $('.subject_edit_btn').click(function () {
    $('.subject_inner').slideToggle();
  });
});

function toggleSubjects() {
  const arrowIcon = document.querySelector('.subject_edit_btn');
  const subjectInner = document.querySelector('.subject_inner');

  subjectInner.classList.toggle('show');
  arrowIcon.textContent = subjectInner.classList.contains('show') ? '選択科目の編集 ▲' : '選択科目の編集 ▼';
}


function toggleSearchConditions() {
  const conditionsInner = document.querySelector('.search_conditions_inner');
  const icon = document.querySelector('.toggle-icon .icon');

  conditionsInner.classList.toggle('show');
  icon.textContent = conditionsInner.classList.contains('show') ? '▲' : '▼';
}
