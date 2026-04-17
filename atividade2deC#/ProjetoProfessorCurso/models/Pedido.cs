namespace ProjetoPedidos.Models;

public class Pedido
{
    public int Id { get; set; }
    public DateTime Data { get; set; }
    public List<ItemPedido> Itens { get; set; } = new();

    public int TotalItens => Itens?.Sum(i => i.Quantidade) ?? 0;
    public decimal ValorTotal => Itens?.Sum(i => i.Quantidade * i.PrecoUnitario) ?? 0;
}
