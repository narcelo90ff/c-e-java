using Microsoft.EntityFrameworkCore;
using ProjetoPedidos.Data;
using ProjetoPedidos.Models;

using var context = new AppDbContext();
context.Database.EnsureCreated();

if (!context.Pedidos.Any())
{
    var pedido = new Pedido
    {
        Data = DateTime.Now,
        Itens = new List<ItemPedido>
        {
            new ItemPedido { Produto = "Notebook",  Quantidade = 1, PrecoUnitario = 3500.00m },
            new ItemPedido { Produto = "Mouse",     Quantidade = 2, PrecoUnitario =   89.90m },
            new ItemPedido { Produto = "Teclado",   Quantidade = 1, PrecoUnitario =  150.00m }
        }
    };

    context.Pedidos.Add(pedido);
    context.SaveChanges();

    Console.WriteLine("✅ Pedido inserido com sucesso!\n");
}

var pedidos = context.Pedidos
    .Include(p => p.Itens)
    .AsNoTracking()
    .ToList();

foreach (var pedido in pedidos)
{
    Console.WriteLine($"🛒 Pedido #{pedido.Id}  |  Data: {pedido.Data:dd/MM/yyyy HH:mm}");
    Console.WriteLine($"{"Produto",-15} {"Qtd",5} {"Preço Unit.">15} {"Subtotal">12}");
    Console.WriteLine(new string('─', 50));

    foreach (var item in pedido.Itens)
    {
        var subtotal = item.Quantidade * item.PrecoUnitario;
        Console.WriteLine($"{item.Produto,-15} {item.Quantidade,5} {item.PrecoUnitario,15:C} {subtotal,12:C}");
    }

    Console.WriteLine(new string('─', 50));

    Console.WriteLine($"{"Total de itens:",-30} {pedido.TotalItens,5}");
    Console.WriteLine($"{"Valor total:",-30} {pedido.ValorTotal,12:C}");
    Console.WriteLine();
}
