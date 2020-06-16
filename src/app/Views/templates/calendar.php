<!-- Calendar -->
<section class="box calendar">
  <div class="inner">
    <table>
      <div class="nav">
        <button onclick="previous()">←</button>
        <button id="next-button" onclick="next()">→</button>
      </div>
      <caption id="calendar-caption"></caption>
      <thead>
        <tr>
          <th scope="col" title="Sunday">S</th>
          <th scope="col" title="Monday">M</th>
          <th scope="col" title="Tuesday">T</th>
          <th scope="col" title="Wednesday">W</th>
          <th scope="col" title="Thursday">T</th>
          <th scope="col" title="Friday">F</th>
          <th scope="col" title="Saturday">S</th>
        </tr>
      </thead>
      <tbody id="calendar-body"></tbody>
    </table>
  </div>
</section>

<script>
  let months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  let today = getDate();
  let currentMonth = today.getMonth();
  let currentYear = today.getFullYear();

  showCalendar(currentYear, currentMonth);

  function next() {
    currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
    currentMonth = (currentMonth + 1) % 12;
    showCalendar(currentYear, currentMonth);
  }

  function previous() {
    currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
    currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
    showCalendar(currentYear, currentMonth);
  }

  function showCalendar(year, month) {
    let firstDay = (new Date(year, month)).getDay();

    let calendarTable = document.getElementById("calendar-body");
    let caption = document.getElementById("calendar-caption");
    let nextButton = document.getElementById("next-button");
    
    nextButton.disabled = year == today.getFullYear() && month == today.getMonth();

    calendarTable.innerHTML = "";

    caption.innerHTML = months[month] + " " + year;

    let date = 1;
    for (let i = 0; i < 6; i++) {
      let row = document.createElement("tr");

      for (let j = 0; j < 7; j++) {
        if (i === 0 && j < firstDay) {
          let cell = document.createElement("td");
          let cellText = document.createTextNode("");
          cell.appendChild(cellText);
          row.appendChild(cell);
        }
        else if (date > daysInMonth(month, year)) {
          break;
        }
        else {
          let cell = document.createElement("td");
          let cellLink = document.createElement("a");
          let cellText = document.createTextNode(date);

          cellLink.innerHtml = date;
          if (date === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
            cell.classList.add("today");
          }
            
          cellLink.href = `/write/${year}-${month + 1}-${date}`;
          cellLink.setAttribute("id", `cal-day-${date}`);
          cellLink.appendChild(cellText);
          cell.appendChild(cellLink);
          row.appendChild(cell);
          date++;
        }
      }

      calendarTable.appendChild(row);
    }

    linkEntryDays(year, month);
  }

  function linkEntryDays(year, month) {
    return fetch(`/calendar/${year}/${month + 1}`)
    .then(response => response.json())
    .then(entryDays => {
      for(let day of entryDays) {
        if(day !== today.getDate() || year !== today.getFullYear() || month !== today.getMonth()) {
          let calDay = document.getElementById(`cal-day-${day}`);
          calDay.classList.add("entry");
          calDay.href=`/${year}-${month + 1}-${day}`;
        }
      }
    });
  }

  function getDate() {
    const dateString = <?= !empty($calDate) ? '"'.Date("Y/m/d", strtotime($calDate)).'"' : 'null' ?>;
    return dateString == null ? new Date() : new Date(dateString);
  }

  // check how many days in a month code from https://dzone.com/articles/determining-number-days-month
  function daysInMonth(iMonth, iYear) {
      return 32 - new Date(iYear, iMonth, 32).getDate();
  }
</script>