namespace ProjetoPedidos.Models;

public class ItemPedido
{
    public int Id { get; set; }
    public string Produto { get; set; } = string.Empty;
    public int Quantidade { get; set; }

    public decimal PrecoUnitario { get; set; }

    public int PedidoId { get; set; }

    public Pedido Pedido { get; set; } = null!;
}
