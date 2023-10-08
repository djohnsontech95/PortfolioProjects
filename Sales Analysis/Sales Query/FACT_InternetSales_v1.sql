--Cleansed FACT_InternetSales Table--
SELECT
	ProductKey AS [Product Key],
    OrderDateKey,
    DueDateKey,
    ShipDateKey,
    CustomerKey AS [Customer Key],
    --[PromotionKey]
    --[CurrencyKey]
    --[SalesTerritoryKey]
    SalesOrderNumber,
    --[SalesOrderLineNumber]
    --[RevisionNumber]
    --[OrderQuantity]
    --[UnitPrice]
    --[ExtendedAmount]
    --[UnitPriceDiscountPct]
    --[DiscountAmount]
    --[ProductStandardCost]
    --[TotalProductCost]
    SalesAmount AS [Sales Amount]
    --[TaxAmt]
    --[Freight]
    --[CarrierTrackingNumber]
    --[CustomerPONumber]
    --[OrderDate]
    --[DueDate]
    --[ShipDate]
FROM 
    AdventureWorksDW2019.dbo.FactInternetSales
WHERE
	LEFT (OrderDateKey, 4) >= YEAR(GETDATE()) - 2 --Ensures query only grabs two years prior of date from extraction
ORDER BY
	OrderDateKey ASC