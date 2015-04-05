
-- tabla de grupos de articulo
SELECT ItmsGrpCod, ItmsGrpNam FROM OITB
#Esta nos da los nonbres de cada grupo

-- esta es una tabla de grupos creada por ellos , 
--no se porque pero creo que la que tendras que usar es esta y el FK en la de articulos es U_Familia
SELECT Code, Name FROM [@BLUE_FAMILIAS]

-- tabla de subgrupo
SELECT FirmCode, FirmName FROM OMRC

-- tabla de articulo
SELECT ItemCode, ItemName, ItmsGrpCod, CreateDate, UpdateDate FROM OITM

--tabla de precios
SELECT ItemCode, PriceList, Price, Currency FROM ITM1
 -- lista de precios se define por cliente , entonces no se bien como lo van a usar ustedes , cual lista de precios
 
-- en la siguiente son los articulos solo que te agregue unas condiciones que son para asegurar que sean inventariables, que sean articulos de venta y que sean activos
SELECT ItemCode, ItemName, ItmsGrpCod, FirmCode, CreateDate, UpdateDate, U_Familia, U_Color, U_DatosImpresion, U_DescripcionAmplia, UserText, PicturName FROM OITM TI
WHERE TI.SellItem = 'Y' AND TI.InvntItem = 'Y' 
AND ((TI.validFor = 'N' AND TI.FrozenFor='N') OR
	(TI.validFor = 'Y' AND (TI.validFrom IS NULL OR TI.validFrom <= GETDATE()) AND (TI.validTo IS NULL OR TI.validTo >= GETDATE())) OR
	(TI.frozenFor = 'Y' AND (((TI.frozenFrom<GETDATE() OR TI.frozenFrom IS NULL) AND TI.frozenTo < GETDATE()) OR 
    (TI.frozenFrom > GETDATE() AND (TI.frozenTo > GETDATE() OR TI.frozenTo IS NULL)))))
    
--Comentarios adicionales. Ellos manejan varios colores por articulo. 
Para saber si es el mismo articulo usan un campo de la tabla OITM (articulo) SWW, que lleva el codigo del articulo padre.