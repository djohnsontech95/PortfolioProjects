-- Standardize Date Format --

ALTER TABLE HousingData
ADD SalesDateConverted Date;

SELECT SalesDateConverted, CONVERT(Date,SaleDate)
FROM PortfolioProject.dbo.HousingData;

UPDATE HousingData
SET SalesDateConverted = CONVERT(Date,SaleDate);

-- Populate Property Address Data --

SELECT *
FROM PortfolioProject.dbo.HousingData
WHERE PropertyAddress IS NULL;

SELECT a.ParcelID, a.PropertyAddress, b.ParcelID, b.PropertyAddress, ISNULL(a.PropertyAddress,b.PropertyAddress)
FROM PortfolioProject.dbo.HousingData a
JOIN PortfolioProject.dbo.HousingData b
	ON a.ParcelID = b.ParcelID
	AND a.[UniqueID ] <> b.[UniqueID ]
WHERE a.PropertyAddress IS NULL;

UPDATE a
SET PropertyAddress = ISNULL(a.PropertyAddress,b.PropertyAddress)
FROM PortfolioProject.dbo.HousingData a
JOIN PortfolioProject.dbo.HousingData b
	ON a.ParcelID = b.ParcelID
	AND a.[UniqueID ] <> b.[UniqueID ];

-- Breaking out address into individual columns (Address, City, State) --

SELECT PropertyAddress
FROM PortfolioProject.dbo.HousingData;

SELECT
SUBSTRING(PropertyAddress, 1, CHARINDEX(',', PropertyAddress)-1) AS Address,
SUBSTRING(PropertyAddress, CHARINDEX(',', PropertyAddress) + 1, LEN(PropertyAddress)) AS City
FROM PortfolioProject.dbo.HousingData;

ALTER TABLE HousingData
ADD PropertySplitAddress NVARCHAR(255);

UPDATE HousingData
SET PropertySplitAddress = SUBSTRING(PropertyAddress, 1, CHARINDEX(',', PropertyAddress)-1);

ALTER TABLE HousingData
ADD PropertySplitCity NVARCHAR(255);

UPDATE HousingData
SET PropertySplitCity = SUBSTRING(PropertyAddress, CHARINDEX(',', PropertyAddress) + 1, LEN(PropertyAddress));


SELECT OwnerAddress
FROM PortfolioProject.dbo.HousingData

SELECT
PARSENAME(REPLACE(OwnerAddress, ',', '.') , 3) AS Address,
PARSENAME(REPLACE(OwnerAddress, ',', '.') , 2) AS City,
PARSENAME(REPLACE(OwnerAddress, ',', '.') , 1) AS State
FROM PortfolioProject.dbo.HousingData

ALTER TABLE HousingData
ADD OwnerSplitAddress NVARCHAR(255);

UPDATE HousingData
SET OwnerSplitAddress = PARSENAME(REPLACE(OwnerAddress, ',', '.') , 3);

ALTER TABLE HousingData
ADD OwnerSplitCity NVARCHAR(255);

UPDATE HousingData
SET OwnerSplitCity = PARSENAME(REPLACE(OwnerAddress, ',', '.') , 2);

ALTER TABLE HousingData
ADD OwnerSplitState NVARCHAR(255);

UPDATE HousingData
SET OwnerSplitState = PARSENAME(REPLACE(OwnerAddress, ',', '.') , 1);

-- Change Y and N to Yes and No in "Sold as Vacant" field --

SELECT DISTINCT(SoldAsVacant), Count(SoldAsVacant)
FROM PortfolioProject.dbo.HousingData
GROUP BY SoldAsVacant
ORDER BY 2;

SELECT SoldAsVacant,
CASE WHEN SoldAsVacant = 'Y' THEN 'Yes'
	 WHEN SoldAsVacant = 'N' THEN 'No'
	 ELSE SoldAsVacant
	 END
FROM PortfolioProject.dbo.HousingData;

UPDATE HousingData
SET SoldAsVacant = CASE WHEN SoldAsVacant = 'Y' THEN 'Yes'
	 WHEN SoldAsVacant = 'N' THEN 'No'
	 ELSE SoldAsVacant
	 END;

-- Remove Duplicates --

