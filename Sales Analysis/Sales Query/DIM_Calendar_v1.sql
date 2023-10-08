-- Cleansed DIM_DataTable --
SELECT 
  DateKey, 
  FullDateAlternateKey AS Date,
  --,[DayNumberOfWeek]
  EnglishDayNameOfWeek AS Day, 
  --,[SpanishDayNameOfWeek]
  --,[FrenchDayNameOfWeek]
  --,[DayNumberOfMonth]
  --,[DayNumberOfYear]
  WeekNumberOfYear AS WeekNumber, 
  EnglishMonthName AS Month, 
  --,[SpanishMonthName]
  --,[FrenchMonthName]
  MonthNumberOfYear AS MonthNumber, 
  CalendarQuarter AS Quarter, 
  CalendarYear AS Year
  --,[CalendarSemester]
  --,[FiscalQuarter]
  --,[FiscalYear]
  --,[FiscalSemester]
FROM 
  AdventureWorksDW2019.dbo.DimDate
WHERE CalendarYear >= 2019
